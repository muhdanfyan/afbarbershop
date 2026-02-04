const {
    default: makeWASocket,
    useMultiFileAuthState,
    DisconnectReason,
    fetchLatestBaileysVersion,
    makeInMemoryStore,
    jidDecode,
} = require("@whiskeysockets/baileys");
const { Boom } = require("@hapi/boom");
const P = require("pino");
const QR = require("qrcode");
const express = require("express");
const bodyParser = require("body-parser");
const fs = require("fs");
require("dotenv").config();

const logger = P({ level: "info" });
const store = makeInMemoryStore({ logger });
store.readFromFile("./baileys_store_multi.json");
setInterval(() => {
    store.writeToFile("./baileys_store_multi.json");
}, 10000);

const app = express();
app.use(bodyParser.json());
const port = process.env.PORT || 3001;
const apiKey = process.env.API_KEY;

// Middleware to check API Key
const apiKeyMiddleware = (req, res, next) => {
    const providedKey = req.headers["x-api-key"] || req.query.api_key;
    if (providedKey !== apiKey) {
        return res.status(401).json({
            status: "error",
            message: "Unauthorized: Invalid API Key",
        });
    }
    next();
};

let sock;
let qrCode;
let connectionStatus = "initializing";

async function connectToWhatsApp() {
    const { state, saveCreds } =
        await useMultiFileAuthState("auth_info_baileys");
    const { version, isLatest } = await fetchLatestBaileysVersion();

    console.log(`using WA v${version.join(".")}, isLatest: ${isLatest}`);

    sock = makeWASocket({
        version,
        logger,
        printQRInTerminal: true,
        auth: state,
        getMessage: async (key) => {
            if (store) {
                const msg = await store.loadMessage(key.remoteJid, key.id);
                return msg?.message || undefined;
            }
            return {
                conversation: "hello",
            };
        },
    });

    store.bind(sock.ev);

    sock.ev.on("connection.update", (update) => {
        const { connection, lastDisconnect, qr } = update;
        if (qr) {
            qrCode = qr;
        }
        if (connection === "close") {
            connectionStatus = "closed";
            const shouldReconnect =
                (lastDisconnect.error instanceof Boom)?.output?.statusCode !==
                DisconnectReason.loggedOut;
            console.log(
                "connection closed due to ",
                lastDisconnect.error,
                ", reconnecting ",
                shouldReconnect,
            );
            // reconnect if not logged out
            if (shouldReconnect) {
                connectToWhatsApp();
            }
        } else if (connection === "open") {
            connectionStatus = "connected";
            qrCode = null;
            console.log("opened connection");
        }
    });

    sock.ev.on("creds.update", saveCreds);

    sock.ev.on("messages.upsert", async (m) => {
        const msg = m.messages[0];
        if (!msg.message) return;
        if (msg.key.fromMe) return;

        const remoteJid = msg.key.remoteJid;
        const body =
            msg.message.conversation || msg.message.extendedTextMessage?.text;

        if (body === "ping") {
            await sock.sendMessage(remoteJid, { text: "pong" });
        }
    });

    return sock;
}

app.get("/", (req, res) => {
    res.json({
        status: connectionStatus,
        connected: connectionStatus === "connected",
        hasQr: !!qrCode,
        user: sock?.user || null,
    });
});

app.get("/api/qr", apiKeyMiddleware, async (req, res) => {
    if (connectionStatus === "connected") {
        return res
            .status(400)
            .json({ status: "error", message: "WhatsApp already connected" });
    }
    if (!qrCode) {
        return res.status(404).json({
            status: "error",
            message: "QR Code not generated yet or already scanned",
        });
    }

    try {
        const qrImage = await QR.toDataURL(qrCode);
        res.json({ status: "success", qr: qrCode, qrImage: qrImage });
    } catch (err) {
        res.status(500).json({
            status: "error",
            message: "Failed to generate QR Image",
        });
    }
});

app.post("/api/reconnect", apiKeyMiddleware, async (req, res) => {
    try {
        if (sock) {
            sock.ws.close();
        } else {
            connectToWhatsApp();
        }
        res.json({ status: "success", message: "Reconnecting..." });
    } catch (err) {
        res.status(500).json({ status: "error", message: err.message });
    }
});

app.post("/api/logout", apiKeyMiddleware, async (req, res) => {
    try {
        if (sock) {
            await sock.logout();
            sock.end();
        }

        // Remove auth session files
        const authPath = "auth_info_baileys";
        if (fs.existsSync(authPath)) {
            fs.rmSync(authPath, { recursive: true, force: true });
        }

        connectionStatus = "logged_out";
        qrCode = null;

        res.json({
            status: "success",
            message: "Logged out and session cleared",
        });

        // Optional: Re-initialize to show new QR
        setTimeout(() => connectToWhatsApp(), 2000);
    } catch (err) {
        res.status(500).json({ status: "error", message: err.message });
    }
});

app.post("/api/send-message", apiKeyMiddleware, async (req, res) => {
    const { number, message } = req.body;

    if (!sock) {
        return res
            .status(500)
            .json({ status: "error", message: "WhatsApp not connected" });
    }

    try {
        const jid = number.includes("@s.whatsapp.net")
            ? number
            : `${number}@s.whatsapp.net`;
        await sock.sendMessage(jid, { text: message });
        res.status(200).json({ status: "success", message: "Message sent" });
    } catch (error) {
        res.status(500).json({ status: "error", message: error.message });
    }
});

app.listen(port, () => {
    console.log(`Gateway API listening on port ${port}`);
});

connectToWhatsApp();
