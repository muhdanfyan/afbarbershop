<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian - Barbershop Queue System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gold: #D4AF37;
            --dark-gold: #B8941F;
            --light-gold: #F4E5C2;
            --bg-dark: #0a0a0a;
            --bg-secondary: #1a1a1a;
            --bg-card: #252525;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --accent-red: #dc3545;
            --accent-green: #28a745;
            --accent-blue: #007bff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg-dark) 0%, #1a1a1a 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(212, 175, 55, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .main-container {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 1600px;
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            padding: 20px 0;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
            margin-bottom: 5px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                filter: brightness(1);
            }

            to {
                filter: brightness(1.2);
            }
        }

        .header .subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .datetime {
            position: absolute;
            top: 20px;
            right: 30px;
            text-align: right;
        }

        .datetime .time {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-gold);
            font-family: 'Playfair Display', serif;
        }

        .datetime .date {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            flex: 1;
            margin-bottom: 20px;
        }

        /* Left Panel - Current Serving */
        .left-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .current-serving {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-secondary));
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(212, 175, 55, 0.3);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .current-serving::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-gold), transparent, var(--primary-gold));
            border-radius: 20px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .serving-label {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .serving-number {
            font-size: 4rem;
            font-weight: 900;
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, var(--primary-gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 2s ease-in-out infinite;
            margin: 15px 0;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .kapster-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            padding: 15px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 10px;
        }

        .kapster-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--primary-gold);
            object-fit: cover;
        }

        .kapster-details {
            text-align: left;
        }

        .kapster-name {
            font-weight: 600;
            color: var(--primary-gold);
            font-size: 1.1rem;
        }

        .service-type {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* Center Panel - Kapsters Status */
        .center-panel {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            overflow-y: auto;
        }

        .panel-title {
            color: var(--primary-gold);
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            background: var(--bg-card);
            padding: 10px 0;
            z-index: 10;
        }

        .kapsters-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .kapster-card {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 15px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .kapster-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-gold);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .kapster-card.active::before {
            transform: scaleY(1);
        }

        .kapster-card.active {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), var(--bg-card));
            border-color: var(--primary-gold);
            animation: activePulse 2s ease-in-out infinite;
        }

        @keyframes activePulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
            }

            50% {
                box-shadow: 0 0 30px rgba(212, 175, 55, 0.4);
            }
        }

        .kapster-card:hover {
            transform: translateX(5px);
        }

        .kapster-card-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .kapster-card.active .kapster-card-img {
            border-color: var(--primary-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        }

        .kapster-card-info {
            flex: 1;
        }

        .kapster-card-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .kapster-card-status {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: blink 2s ease-in-out infinite;
        }

        .status-indicator.busy {
            background: var(--accent-red);
        }

        .status-indicator.available {
            background: var(--accent-green);
        }

        .status-indicator.serving {
            background: var(--primary-gold);
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .kapster-card-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-gold);
            font-family: 'Playfair Display', serif;
        }

        /* Right Panel - Queue List */
        .right-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .queue-section {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .queue-list {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-right: 10px;
        }

        .queue-list::-webkit-scrollbar {
            width: 6px;
        }

        .queue-list::-webkit-scrollbar-track {
            background: var(--bg-secondary);
            border-radius: 3px;
        }

        .queue-list::-webkit-scrollbar-thumb {
            background: var(--primary-gold);
            border-radius: 3px;
        }

        .queue-item {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .queue-item:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: translateX(5px);
        }

        .queue-number {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-gold);
            font-family: 'Playfair Display', serif;
        }

        .queue-details {
            text-align: right;
        }

        .queue-service {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .queue-time {
            color: var(--primary-gold);
            font-size: 0.75rem;
            margin-top: 2px;
        }

        /* Statistics Bar */
        .stats-bar {
            display: flex;
            gap: 20px;
            padding: 15px;
            background: linear-gradient(135deg, var(--bg-card), var(--bg-secondary));
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .stat-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-right: 1px solid rgba(212, 175, 55, 0.2);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-gold);
            font-family: 'Playfair Display', serif;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* Control Panel */
        .control-panel {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            gap: 15px;
            z-index: 1000;
        }

        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-gold), var(--dark-gold));
            border: none;
            color: var(--bg-dark);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .control-btn:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.6);
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(212, 175, 55, 0.3);
            border-top-color: var(--primary-gold);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Notification Toast */
        .notification-toast {
            position: fixed;
            top: 30px;
            right: -400px;
            background: linear-gradient(135deg, var(--bg-card), var(--bg-secondary));
            border-left: 4px solid var(--primary-gold);
            border-radius: 10px;
            padding: 20px;
            min-width: 350px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            transition: right 0.5s ease;
            z-index: 2000;
        }

        .notification-toast.show {
            right: 30px;
        }

        .notification-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background: rgba(212, 175, 55, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-gold);
            font-size: 1.2rem;
        }

        .notification-title {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .notification-message {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Sound Wave Animation */
        .sound-wave {
            display: inline-flex;
            gap: 3px;
            align-items: center;
            height: 20px;
        }

        .sound-wave span {
            width: 3px;
            height: 100%;
            background: var(--primary-gold);
            border-radius: 3px;
            animation: wave 1s ease-in-out infinite;
        }

        .sound-wave span:nth-child(2) {
            animation-delay: 0.1s;
        }

        .sound-wave span:nth-child(3) {
            animation-delay: 0.2s;
        }

        .sound-wave span:nth-child(4) {
            animation-delay: 0.3s;
        }

        @keyframes wave {

            0%,
            100% {
                height: 20%;
            }

            50% {
                height: 100%;
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 1fr 1fr;
            }

            .right-panel {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .right-panel {
                grid-column: span 1;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .datetime {
                position: static;
                text-align: center;
                margin-top: 10px;
            }

            .stats-bar {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <h1>{{ $settings['nama_usaha'] }}</h1>
            <p class="subtitle">{{ $settings['slogan'] }}</p>
            <div class="datetime">
                <div class="time" id="time">00:00:00</div>
                <div class="date" id="date">Senin, 1 Januari 2024</div>
            </div>
        </header>

        <!-- Statistics Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="totalWaiting">8</div>
                <div class="stat-label">Antrian</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="avgWait">12</div>
                <div class="stat-label">Est. Menit</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="servedToday">42</div>
                <div class="stat-label">Dilayani</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="activeKapsters">3</div>
                <div class="stat-label">Kapster Aktif</div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Panel - Current Serving -->
            <div class="left-panel">
                <div class="current-serving">
                    <div class="serving-label">Sedang Dilayani</div>
                    <div class="serving-number" id="currentNumber">B015</div>
                    <div class="kapster-info">
                        <img src="https://picsum.photos/seed/kapster1/100/100" alt="Kapster" class="kapster-avatar"
                            id="currentKapsterAvatar">
                        <div class="kapster-details">
                            <div class="kapster-name" id="currentKapsterName">Andi Pratama</div>
                            <div class="service-type" id="currentService">Haircut & Styling</div>
                        </div>
                        <div class="sound-wave" id="soundWave" style="display: none;">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center Panel - Kapsters Status -->
            <div class="center-panel">
                <h3 class="panel-title">
                    <i class="fas fa-users"></i>
                    Status Kapster
                </h3>
                <div class="kapsters-grid" id="kapstersGrid">
                    <!-- Kapsters will be loaded here from database -->
                </div>
            </div>

            <!-- Right Panel - Queue List -->
            <div class="right-panel">
                <div class="queue-section">
                    <h3 class="panel-title">
                        <i class="fas fa-list-ol"></i>
                        Antrian Selanjutnya
                    </h3>
                    <div class="queue-list" id="queueList">
                        <!-- Queue items will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Panel -->
    <div class="control-panel">
        <button class="control-btn" onclick="playSound()" title="Putar Suara">
            <i class="fas fa-volume-up"></i>
        </button>
        <button class="control-btn" onclick="nextQueue()" title="Antrian Selanjutnya">
            <i class="fas fa-arrow-right"></i>
        </button>
        <button class="control-btn" onclick="refreshData()" title="Refresh">
            <i class="fas fa-sync-alt"></i>
        </button>
        <button class="control-btn" onclick="toggleFullscreen()" title="Fullscreen">
            <i class="fas fa-expand"></i>
        </button>
    </div>

    <!-- Notification Toast -->
    <div class="notification-toast" id="notificationToast">
        <div class="notification-header">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
            </div>
            <div>
                <div class="notification-title">Pemanggilan Antrian</div>
                <div class="notification-message" id="notificationMessage">Nomor B015 dipanggil</div>
            </div>
        </div>
    </div>

    <!-- Audio for queue announcement -->
    <audio id="queueSound" preload="auto">
        <source
            src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmFgU7k9n1unEiBC13yO/eizEIHWq+8+OWT"
            type="audio/wav">
    </audio>

    <script>
        // Mock Database - Simulating API call
        const kapstersDatabase = [
            {
                id: 1,
                name: "Andi Pratama",
                avatar: "https://picsum.photos/seed/andi/100/100",
                status: "serving",
                currentQueue: "B015",
                service: "Haircut & Styling",
                specialty: "Classic Cut"
            },
            {
                id: 2,
                name: "Budi Santoso",
                avatar: "https://picsum.photos/seed/budi/100/100",
                status: "serving",
                currentQueue: "B014",
                service: "Beard Trim",
                specialty: "Beard Design"
            },
            {
                id: 3,
                name: "Rizki Ahmad",
                avatar: "https://picsum.photos/seed/rizki/100/100",
                status: "serving",
                currentQueue: "B013",
                service: "Hair Coloring",
                specialty: "Color Specialist"
            },
            {
                id: 4,
                name: "Fajar Nugroho",
                avatar: "https://picsum.photos/seed/fajar/100/100",
                status: "available",
                currentQueue: null,
                service: null,
                specialty: "Modern Style"
            },
            {
                id: 5,
                name: "Eko Prasetyo",
                avatar: "https://picsum.photos/seed/eko/100/100",
                status: "busy",
                currentQueue: null,
                service: "Break Time",
                specialty: "Kids Cut"
            }
        ];

        const services = [
            "Haircut & Styling",
            "Beard Trim",
            "Hair Coloring",
            "Hair Treatment",
            "Shave & Facial",
            "Kids Haircut"
        ];

        let currentQueueNumber = 15;
        let currentKapsterIndex = 0;
        let queueData = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            loadKapstersFromDatabase();
            initializeQueueList();
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Simulate real-time updates
            setInterval(simulateDatabaseUpdate, 10000);
        });

        // Load Kapsters from Database
        function loadKapstersFromDatabase() {
            const kapstersGrid = document.getElementById('kapstersGrid');
            kapstersGrid.innerHTML = '<div class="loading-spinner"></div>';

            // Simulate API delay
            setTimeout(() => {
                kapstersGrid.innerHTML = '';
                kapstersDatabase.forEach((kapster, index) => {
                    const kapsterCard = createKapsterCard(kapster, index);
                    kapstersGrid.appendChild(kapsterCard);
                });

                // Set first serving kapster as current
                const servingKapster = kapstersDatabase.find(k => k.status === 'serving');
                if (servingKapster) {
                    updateCurrentServing(servingKapster);
                }
            }, 1000);
        }

        // Create Kapster Card
        function createKapsterCard(kapster, index) {
            const card = document.createElement('div');
            card.className = `kapster-card ${kapster.status === 'serving' ? 'active' : ''}`;
            card.innerHTML = `
                <img src="${kapster.avatar}" alt="${kapster.name}" class="kapster-card-img">
                <div class="kapster-card-info">
                    <div class="kapster-card-name">${kapster.name}</div>
                    <div class="kapster-card-status">
                        <span class="status-indicator ${kapster.status}"></span>
                        <span>${getStatusText(kapster.status, kapster.service)}</span>
                    </div>
                </div>
                <div class="kapster-card-number">
                    ${kapster.currentQueue || '-'}
                </div>
            `;

            card.onclick = () => selectKapster(kapster, index);
            return card;
        }

        // Get Status Text
        function getStatusText(status, service) {
            switch (status) {
                case 'serving': return service || 'Sedang Melayani';
                case 'available': return 'Tersedia';
                case 'busy': return 'Sibuk';
                default: return 'Offline';
            }
        }

        // Select Kapster
        function selectKapster(kapster, index) {
            if (kapster.status === 'available') {
                currentKapsterIndex = index;
                showNotification('Kapster Dipilih', `${kapster.name} siap melayani`);
            }
        }

        // Update Current Serving
        function updateCurrentServing(kapster) {
            const currentNumber = document.getElementById('currentNumber');
            const currentKapsterName = document.getElementById('currentKapsterName');
            const currentKapsterAvatar = document.getElementById('currentKapsterAvatar');
            const currentService = document.getElementById('currentService');

            currentNumber.textContent = kapster.currentQueue || '-';
            currentKapsterName.textContent = kapster.name;
            currentKapsterAvatar.src = kapster.avatar;
            currentService.textContent = kapster.service || 'Menunggu';
        }

        // Initialize Queue List
        function initializeQueueList() {
            queueData = [];
            for (let i = 1; i <= 8; i++) {
                queueData.push({
                    number: `B${String(currentQueueNumber + i).padStart(3, '0')}`,
                    service: services[Math.floor(Math.random() * services.length)],
                    time: i * 5
                });
            }
            renderQueueList();
        }

        // Render Queue List
        function renderQueueList() {
            const queueList = document.getElementById('queueList');
            queueList.innerHTML = '';

            queueData.forEach((queue, index) => {
                const queueItem = document.createElement('div');
                queueItem.className = 'queue-item';
                queueItem.innerHTML = `
                    <span class="queue-number">${queue.number}</span>
                    <div class="queue-details">
                        <div class="queue-service">${queue.service}</div>
                        <div class="queue-time">Est. ${queue.time} menit</div>
                    </div>
                `;
                queueList.appendChild(queueItem);
            });
        }

        // Next Queue
        function nextQueue() {
            // Find available kapster
            const availableKapster = kapstersDatabase.find(k => k.status === 'available');
            if (!availableKapster) {
                showNotification('Tidak Ada Kapster', 'Semua kapster sedang sibuk');
                return;
            }

            // Update queue number
            currentQueueNumber++;
            const newQueueNumber = `B${String(currentQueueNumber).padStart(3, '0')}`;

            // Update kapster status
            availableKapster.status = 'serving';
            availableKapster.currentQueue = newQueueNumber;
            availableKapster.service = queueData[0].service;

            // Remove first queue and add new
            queueData.shift();
            queueData.push({
                number: `B${String(currentQueueNumber + 8).padStart(3, '0')}`,
                service: services[Math.floor(Math.random() * services.length)],
                time: 40
            });

            // Update displays
            updateCurrentServing(availableKapster);
            loadKapstersFromDatabase();
            renderQueueList();
            updateStatistics();

            // Show notification and play sound
            showNotification('Antrian Berikutnya', `Nomor ${newQueueNumber} dengan ${availableKapster.name}`);
            playSound();
        }

        // Update Statistics
        function updateStatistics() {
            const totalWaiting = document.getElementById('totalWaiting');
            const servedToday = document.getElementById('servedToday');

            totalWaiting.textContent = Math.max(0, parseInt(totalWaiting.textContent) - 1);
            servedToday.textContent = parseInt(servedToday.textContent) + 1;
        }

        // Simulate Database Update
        function simulateDatabaseUpdate() {
            // Randomly update kapster status
            const randomKapster = kapstersDatabase[Math.floor(Math.random() * kapstersDatabase.length)];
            const statuses = ['available', 'busy', 'serving'];

            if (randomKapster.status !== 'serving') {
                randomKapster.status = statuses[Math.floor(Math.random() * 2)];
                loadKapstersFromDatabase();
            }

            // Update random statistics
            const avgWait = document.getElementById('avgWait');
            const currentWait = parseInt(avgWait.textContent);
            avgWait.textContent = Math.max(5, currentWait + Math.floor(Math.random() * 5) - 2);
        }

        // Update Date and Time
        function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('time').textContent = timeString;
            document.getElementById('date').textContent = dateString;
        }

        // Play Sound
        function playSound() {
            const audio = document.getElementById('queueSound');
            const soundWave = document.getElementById('soundWave');

            soundWave.style.display = 'inline-flex';
            audio.play().catch(e => console.log('Audio play failed:', e));

            setTimeout(() => {
                soundWave.style.display = 'none';
            }, 3000);
        }

        // Show Notification
        function showNotification(title, message) {
            const toast = document.getElementById('notificationToast');
            const messageEl = document.getElementById('notificationMessage');

            document.querySelector('.notification-title').textContent = title;
            messageEl.textContent = message;

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }

        // Refresh Data
        function refreshData() {
            const btn = event.target.closest('.control-btn');
            const icon = btn.querySelector('i');
            icon.style.animation = 'spin 1s linear';

            // Reload data from database
            loadKapstersFromDatabase();
            renderQueueList();

            setTimeout(() => {
                icon.style.animation = '';
                showNotification('Data Diperbarui', 'Semua data telah diperbarui dari database');
            }, 1000);
        }

        // Toggle Fullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                event.target.closest('.control-btn').querySelector('i').className = 'fas fa-compress';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    event.target.closest('.control-btn').querySelector('i').className = 'fas fa-expand';
                }
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowRight':
                    nextQueue();
                    break;
                case ' ':
                    e.preventDefault();
                    playSound();
                    break;
                case 'r':
                    refreshData();
                    break;
                case 'f':
                    toggleFullscreen();
                    break;
            }
        });
    </script>
</body>

</html>