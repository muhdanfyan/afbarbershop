<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian - Barbershop Queue System</title>
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            if (theme === 'dark') document.documentElement.classList.add('dark');
        })();

        function updateThemeIcon(isDark) {
            const icon = document.getElementById('theme-icon');
            if (icon) {
                if (isDark) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun', 'text-warning');
                } else {
                    icon.classList.remove('fa-sun', 'text-warning');
                    icon.classList.add('fa-moon');
                }
            }
        }
        
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon(isDark);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            updateThemeIcon(isDark);
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gold: #D4AF37;
            --dark-gold: #B8941F;
            --light-gold: #F4E5C2;
            --bg-dark: #f8f9fa;
            --bg-secondary: #e9ecef;
            --bg-card: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --accent-red: #dc3545;
            --accent-green: #28a745;
            --accent-blue: #007bff;
            --border-color: rgba(0, 0, 0, 0.1);
        }

        html.dark {
            --bg-dark: #0a0a0a;
            --bg-secondary: #1a1a1a;
            --bg-card: #252525;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --border-color: rgba(212, 175, 55, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            transition: background 0.3s ease, color 0.3s ease;
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
            padding: 15px 20px;
            max-width: 1600px;
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Logo Inversion for Light Mode */
        .theme-logo {
            transition: filter 0.5s ease-in-out;
            max-height: 80px; /* Constrain desktop height */
            width: auto;
        }
        
        html:not(.dark) .theme-logo {
            filter: brightness(0);
        }

        .logo-animation {
            /* Animation pulse removed as requested */
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 5px; /* Reduced for desktop */
            position: relative;
            padding: 5px 0; /* Reduced for desktop */
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--text-primary);
            margin-bottom: 0px;
        }

        html.dark .header h1 {
            background: linear-gradient(135deg, var(--primary-gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
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
            font-size: 1.3rem;
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
            gap: 15px;
            flex: 1;
            margin-bottom: 10px;
            min-height: 0;
        }

        /* Left Panel - Current Serving */
        .left-panel {
            display: flex;
            flex-direction: column;
            gap: 15px;
            min-height: 0;
        }

        .current-serving {
            background: linear-gradient(135deg, var(--bg-card), var(--bg-secondary));
            border-radius: 20px;
            padding: 20px 15px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--border-color);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: background 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        
        html.dark .current-serving {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
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
            font-size: 3.5rem;
            font-weight: 900;
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, var(--primary-gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 5px 0;
            line-height: 1.1;
        }

        @keyframes pulse {
            /* Pulse animation preserved for reference but removed from selector */
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
            margin-top: 10px;
            padding: 10px;
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
            padding: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        html.dark .center-panel {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
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
            padding: 10px 15px;
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
            width: 50px;
            height: 50px;
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
            padding: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        html.dark .queue-section {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
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
            padding: 8px 12px;
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
            gap: 15px;
            padding: 10px 15px;
            background: linear-gradient(135deg, var(--bg-card), var(--bg-secondary));
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .stat-item {
            flex: 1;
            text-align: center;
            padding: 5px;
            border-right: 1px solid rgba(212, 175, 55, 0.2);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-value {
            font-size: 1.5rem;
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

            .header .theme-logo {
                height: 3rem !important; /* Made smaller as requested */
            }

            .main-container {
                height: auto;
                min-height: 100vh;
                padding: 10px;
                overflow-y: auto; /* Allow scrolling if content overflows */
            }

            .current-serving {
                padding: 15px 10px !important;
                min-height: 160px; /* Reduced min-height */
                overflow: visible !important; /* Ensure number doesn't get cut */
            }

            .serving-number {
                font-size: 2.5rem !important; /* Reduced further to prevent cut-off */
                margin: 2px 0 !important;
                line-height: 1 !important;
            }

            .datetime {
                position: static;
                text-align: center;
                margin-top: 10px;
            }

            .stats-bar {
                flex-wrap: wrap;
                gap: 10px;
            }

            .stat-item {
                flex: 1 1 40%;
                border-right: none;
                border-bottom: 1px solid rgba(212, 175, 55, 0.1);
                padding: 10px 5px;
            }

            .stat-item:nth-child(even) {
                border-left: 1px solid rgba(212, 175, 55, 0.1);
            }

            .stat-item:nth-last-child(-n+2) {
                border-bottom: none;
            }
        }
        /* YouTube Panel & Overlay */
        .youtube-panel {
            position: relative;
            cursor: pointer;
        }

        .video-control-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 100;
        }

        .youtube-panel:hover .video-control-overlay {
            opacity: 1;
        }

        .video-overlay-btn {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--primary-gold);
            color: var(--primary-gold);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .video-overlay-btn:hover {
            background: var(--primary-gold);
            color: #000;
            transform: scale(1.1);
        }

        /* Fullscreen Mode Fix */
        .youtube-panel:fullscreen {
            width: 100vw !important;
            height: 100vh !important;
            border: none !important;
            border-radius: 0 !important;
            background: #000;
        }

        .youtube-panel:fullscreen .video-control-overlay {
            top: 20px;
            right: 20px;
        }

        /* Playlist Modal Styling */
        .playlist-modal .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--primary-gold);
            border-radius: 20px;
            overflow: hidden;
        }

        .playlist-card {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .playlist-card:hover {
            border-color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.1);
            transform: translateY(-2px);
        }

        .playlist-card.active {
            border-color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.1);
        }

        .playlist-thumbnail {
            width: 60px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary" style="position: absolute; left: 0px; top: 10px; border-color: var(--primary-gold); color: inherit; font-size: 0.9rem;" title="Kembali ke Beranda">
                <i class="fas fa-home"></i> <span class="d-none d-md-inline ms-1">Home</span>
            </a>
            <div class="mb-1">
                <img src="{{ asset('/') }}logoposeidonputih.png" alt="{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} Logo" class="theme-logo">
            </div>
            <p class="subtitle" style="margin-top: -5px;">{{ $settings['slogan'] }}</p>
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

                <div class="youtube-panel" id="youtubePanel" style="width: 100%; height: 180px; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); border: 2px solid var(--border-color); transition: border-color 0.3s ease, box-shadow 0.3s ease; flex-shrink: 0;">
                    <!-- Overlay Buttons -->
                    <div class="video-control-overlay">
                        <button class="video-overlay-btn" onclick="toggleVideoFullscreen()" title="Fullscreen">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </button>
                        <button class="video-overlay-btn" data-bs-toggle="modal" data-bs-target="#playlistExplorer" title="Playlist Explorer">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    @php
                        $mediaSrc = "https://www.youtube.com/embed/jfKfPfyJRdk?playlist=rUxyKA_-grg,5qap5aO4i9A,7NOSDKb0H6k,w1hS_xL4DCM&autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&loop=1";
                        $isSpotify = false;
                        
                        // Helper to extract IDs if not already sanitized (though admin does it)
                        $extractId = function($input, $jenis = 'youtube_video') {
                            if (str_contains($jenis, 'spotify')) {
                                if (preg_match('/(?:spotify:|(?:https?:\/\/)?open\.spotify\.com\/(?:intl-[a-z]+\/)?(track|playlist|album)\/)([a-zA-Z0-9]+)(?:.*)$/', $input, $matches)) {
                                    return $matches[2];
                                }
                                return $input;
                            }
                            if (preg_match('/list=([^&]+)/', $input, $matches)) return $matches[1];
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $input, $matches)) return $matches[1];
                            return $input;
                        };

                        if(isset($playlists) && count($playlists) > 0) {
                            $first = $playlists->first();
                            $firstId = $extractId($first->url_id, $first->jenis);
                            
                            if(str_contains($first->jenis, 'spotify')) {
                                $isSpotify = true;
                                $type = str_replace('spotify_', '', $first->jenis);
                                $mediaSrc = "https://open.spotify.com/embed/" . $type . "/" . $firstId;
                            } else {
                                if($first->jenis == 'youtube_playlist') {
                                    $mediaSrc = "https://www.youtube.com/embed/videoseries?list=" . $firstId . "&autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&loop=1";
                                } else {
                                    $mediaSrc = "https://www.youtube.com/embed/" . $firstId . "?autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&loop=1&playlist=" . $firstId;
                                    
                                    if(count($playlists) > 1) {
                                        $additionalIds = $playlists->slice(1)->filter(fn($p) => !str_contains($p->jenis, 'spotify'))->map(function($p) use ($extractId) {
                                            return $extractId($p->url_id, $p->jenis);
                                        })->filter()->implode(',');
                                        
                                        if($additionalIds) {
                                            $mediaSrc = str_replace("&playlist=" . $firstId, "&playlist=" . $firstId . "," . $additionalIds, $mediaSrc);
                                        }
                                    }
                                }
                            }
                        }
                    @endphp
                    <!-- Dynamic Dashboard Media (YT/Spotify) -->
                    <iframe id="mediaIframe" width="100%" height="100%" 
                        src="{{ $mediaSrc }}" 
                        role="presentation"
                        title="Barbershop Studio Media" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
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
        <button class="control-btn" onclick="toggleTheme()" title="Toggle Tema">
            <i id="theme-icon" class="fas fa-moon"></i>
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

    <!-- Playlist Explorer Modal -->
    <div class="modal fade playlist-modal" id="playlistExplorer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-play-circle text-warning me-2"></i> Pilih Playlist Studio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="playlist-container" style="max-height: 400px; overflow-y: auto;">
                        @foreach($playlists as $p)
                            <div class="playlist-card" onclick="changeMedia('{{ $p->url_id }}', '{{ $p->jenis }}', this)">
                                <img src="https://img.youtube.com/vi/{{ $p->jenis === 'youtube_video' ? $p->url_id : 'videoseries' }}/default.jpg" 
                                    class="playlist-thumbnail" 
                                    onerror="this.src='{{ asset('images/placeholder-yt.jpg') }}'">
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark small" style="line-height: 1.2;">{{ $p->judul }}</div>
                                    <small class="text-muted text-uppercase" style="font-size: 10px;">{{ str_replace('_', ' ', $p->jenis) }}</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted small opacity-50"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
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
        let currentQueueNumber = 0;
        let queueData = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            refreshData();
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Poll for real-time updates every 5 seconds
            setInterval(refreshData, 5000);
        });

        // Load Data from API
        async function refreshData() {
            try {
                const response = await fetch('/api/queue-data');
                const data = await response.json();
                
                renderKapsters(data.kapsters);
                renderQueueList(data.queue);
                updateStats(data);
                
                // If there's a serving kapster, update the main serving display
                const servingKapster = data.kapsters.find(k => k.status === 'serving');
                if (servingKapster) {
                    updateCurrentServing(servingKapster);
                }
            } catch (error) {
                console.error('Failed to fetch queue data:', error);
            }
        }

        // Render Kapsters
        function renderKapsters(kapsters) {
            const kapstersGrid = document.getElementById('kapstersGrid');
            kapstersGrid.innerHTML = '';
            
            kapsters.forEach((kapster) => {
                const card = document.createElement('div');
                card.className = `kapster-card ${kapster.status === 'serving' ? 'active' : ''}`;
                card.innerHTML = `
                    <img src="${kapster.avatar}" alt="${kapster.name}" class="kapster-card-img">
                    <div class="kapster-card-info">
                        <div class="kapster-card-name">${kapster.name}</div>
                        <div class="kapster-card-status">
                            <span class="status-indicator ${kapster.status}"></span>
                            <span>${getStatusText(kapster.status, kapster.service)}</span>
                            ${kapster.kursi ? `<span class="badge bg-dark-subtle text-warning ms-2 border border-warning-subtle" style="font-size: 0.7rem;">${kapster.kursi}</span>` : ''}
                        </div>
                    </div>
                    <div class="kapster-card-number">
                        ${kapster.currentQueue || '-'}
                    </div>
                `;
                kapstersGrid.appendChild(card);
            });
        }

        // Render Queue List
        function renderQueueList(queues) {
            const queueList = document.getElementById('queueList');
            queueList.innerHTML = '';

            if (queues.length === 0) {
                queueList.innerHTML = '<div class="text-center py-4 opacity-50 small">Tidak ada antrian</div>';
                return;
            }

            queues.forEach((queue) => {
                const queueItem = document.createElement('div');
                queueItem.className = 'queue-item';
                queueItem.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="queue-number">${queue.number}</span>
                        <span class="badge bg-warning-subtle text-dark ms-3 border border-warning" style="font-size: 0.65rem;">${queue.kursi}</span>
                    </div>
                    <div class="queue-details">
                        <div class="queue-service">${queue.service}</div>
                        <div class="queue-time">Pukul ${queue.time}</div>
                    </div>
                `;
                queueList.appendChild(queueItem);
            });
        }

        // Update Stats
        function updateStats(data) {
            document.getElementById('totalWaiting').textContent = data.totalWaiting;
            document.getElementById('servedToday').textContent = data.servedToday;
            document.getElementById('activeKapsters').textContent = data.activeKapsters;
            document.getElementById('avgWait').textContent = data.totalWaiting * 30; // 30 min per person
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

        // Play queue sound and show wave
        function playSound() {
            const sound = document.getElementById('queueSound');
            const wave = document.getElementById('soundWave');
            
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(e => console.log("Audio play blocked:", e));
            }
            
            if (wave) {
                wave.style.display = 'inline-flex';
                setTimeout(() => {
                    wave.style.display = 'none';
                }, 3000);
            }
        }

        // Show notification for next queue
        function nextQueue() {
            const toast = document.getElementById('notificationToast');
            const msg = document.getElementById('notificationMessage');
            
            // Get the first item from the queue list if exists
            const nextItem = document.querySelector('.queue-item .queue-number');
            const number = nextItem ? nextItem.textContent : '---';
            
            if (msg) msg.textContent = `Nomor ${number} dipanggil! Silakan menuju kursi.`;
            if (toast) {
                toast.classList.add('show');
                playSound();
                setTimeout(() => toast.classList.remove('show'), 5000);
            }
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

        // Toggle YouTube Fullscreen
        function toggleVideoFullscreen() {
            const panel = document.getElementById('youtubePanel');
            if (!document.fullscreenElement) {
                if (panel.requestFullscreen) {
                    panel.requestFullscreen();
                } else if (panel.webkitRequestFullscreen) {
                    panel.webkitRequestFullscreen();
                } else if (panel.msRequestFullscreen) {
                    panel.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Change YouTube Media
        function changeMedia(id, type, element) {
            const iframe = document.getElementById('youtubeIframe');
            let src = '';
            
            // Clean ID (Extract in case seeder has URLs)
            const extractId = (input) => {
                const listMatch = input.match(/list=([^&]+)/);
                if (listMatch) return listMatch[1];
                const videoMatch = input.match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i');
                if (videoMatch) return videoMatch[1];
                return input;
            };

            const cleanId = extractId(id);

            if (type === 'youtube_playlist') {
                src = `https://www.youtube.com/embed/videoseries?list=${cleanId}&autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&loop=1`;
            } else {
                src = `https://www.youtube.com/embed/${cleanId}?autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&loop=1&playlist=${cleanId}`;
            }

            iframe.src = src;

            // Highlight active card
            document.querySelectorAll('.playlist-card').forEach(c => c.classList.remove('active'));
            if (element) element.classList.add('active');

            // Close modal using standard data attribute or BS instance
            bootstrap.Modal.getInstance(document.getElementById('playlistExplorer')).hide();
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
                case 'v': // New shortcut for video fullscreen
                    toggleVideoFullscreen();
                    break;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>