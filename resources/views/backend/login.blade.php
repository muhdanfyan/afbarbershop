<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AFBARBERSHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&family=Bebas+Neue&display=swap');

        :root {
            --primary: #000000;
            --accent: #FFD700;
            --secondary: #8B4513;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Bebas Neue', cursive;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        .gold-gradient {
            background: linear-gradient(135deg, #FFD700, #FFA500);
        }

        .input-gold:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
        }

        .btn-gold {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3);
        }

        .scissor-animation {
            animation: scissor-cut 3s ease-in-out infinite;
        }

        @keyframes scissor-cut {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-15deg);
            }

            75% {
                transform: rotate(15deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
        }

        .checkbox-custom:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .loading-spinner {
            border: 3px solid rgba(255, 215, 0, 0.3);
            border-top: 3px solid var(--accent);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--accent);
        }
    </style>
</head>

<body class="min-h-screen bg-black flex items-center justify-center relative overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://www.barberiaindonesia.com/uploads/1/4/4/3/144387242/published/grandindonesia3.png?1679159369"
            alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 gradient-overlay"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 text-accent opacity-20">
        <i class="fas fa-cut text-6xl scissor-animation"></i>
    </div>
    <div class="absolute bottom-10 right-10 text-accent opacity-20">
        <i class="fas fa-shower text-6xl"></i>
    </div>
    <div class="absolute top-1/3 right-20 text-accent opacity-20">
        <i class="fas fa-beard text-5xl"></i>
    </div>

    <livewire:admin.login-index />

    <!-- Success/Error Modal -->
    <div id="messageModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
        <div
            class="bg-gray-900 rounded-2xl p-8 max-w-md mx-4 border border-gray-800 transform scale-95 transition-transform">
            <div class="text-center">
                <div id="modalIcon" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="text-4xl"></i>
                </div>
                <h3 id="modalTitle" class="text-2xl font-bold text-white mb-2"></h3>
                <p id="modalMessage" class="text-gray-400 mb-6"></p>
                <button onclick="closeModal()"
                    class="gold-gradient text-black font-bold py-2 px-6 rounded-full transition-all">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Handle Login
        function handleLogin(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            // Show loading state
            loginBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');

            // Simulate API call
            setTimeout(() => {
                // Reset button state
                loginBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');

                // Demo credentials check
                if (username === 'admin' && password === 'admin123') {
                    showMessage('success', 'Login Berhasil!', 'Selamat datang kembali di AFBARBERSHOP Portal');
                    // Redirect to dashboard after success
                    setTimeout(() => {
                        window.location.href = 'dashboard.html';
                    }, 2000);
                } else if (username === 'member' && password === 'member123') {
                    showMessage('success', 'Login Berhasil!', 'Selamat datang di Member Area');
                    setTimeout(() => {
                        window.location.href = 'member.html';
                    }, 2000);
                } else {
                    showMessage('error', 'Login Gagal!', 'Email atau password salah. Silakan coba lagi.');
                }
            }, 1500);
        }

        // Show Message Modal
        function showMessage(type, title, message) {
            const modal = document.getElementById('messageModal');
            const modalIcon = document.getElementById('modalIcon');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const icon = modalIcon.querySelector('i');

            // Set modal content based on type
            if (type === 'success') {
                modalIcon.className = 'w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4';
                icon.className = 'fas fa-check text-green-500 text-4xl';
            } else {
                modalIcon.className = 'w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4';
                icon.className = 'fas fa-times text-red-500 text-4xl';
            }

            modalTitle.textContent = title;
            modalMessage.textContent = message;

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('div > div').classList.remove('scale-95');
                modal.querySelector('div > div').classList.add('scale-100');
            }, 10);
        }

        // Close Modal
        function closeModal() {
            const modal = document.getElementById('messageModal');
            modal.querySelector('div > div').classList.remove('scale-100');
            modal.querySelector('div > div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Social Login Handlers
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const provider = this.querySelector('span').textContent;
                showMessage('info', `${provider} Login`, `Fitur login dengan ${provider} akan segera tersedia!`);
            });
        });

        // Forgot Password Handler
        document.querySelector('a[href="#"]').addEventListener('click', function (e) {
            if (this.textContent.includes('Lupa password')) {
                e.preventDefault();
                showMessage('info', 'Reset Password', 'Silakan hubungi admin untuk reset password Anda.');
            }
        });

        // Register Handler
        document.querySelector('a[href="#"]').addEventListener('click', function (e) {
            if (this.textContent.includes('Daftar sekarang')) {
                e.preventDefault();
                showMessage('info', 'Pendaftaran', 'Silakan datang langsung ke AFBARBERSHOP untuk pendaftaran member.');
            }
        });

        // Add input animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('scale-105');
            });

            input.addEventListener('blur', function () {
                this.parentElement.classList.remove('scale-105');
            });
        });

        // Demo credentials hint
        console.log('%cDemo Credentials:', 'color: #FFD700; font-size: 16px; font-weight: bold;');
        console.log('%cAdmin: username: admin, password: admin123', 'color: #00ff00;');
        console.log('%cMember: username: member, password: member123', 'color: #00ff00;');
    </script>
</body>

</html>