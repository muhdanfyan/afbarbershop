<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFBARBERSHOP - Premium Grooming & Coffee</title>
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

        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.7) 100%);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .coffee-steam {
            animation: steam 3s ease-out infinite;
        }

        @keyframes steam {
            0% {
                transform: translateY(0) scaleX(1);
                opacity: 0.5;
            }

            50% {
                transform: translateY(-20px) scaleX(1.1);
                opacity: 0.3;
            }

            100% {
                transform: translateY(-40px) scaleX(1.2);
                opacity: 0;
            }
        }

        .scissor-animation {
            animation: scissor-cut 2s ease-in-out infinite;
        }

        @keyframes scissor-cut {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        .razor-animation {
            animation: razor-move 3s ease-in-out infinite;
        }

        @keyframes razor-move {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(10px);
            }
        }

        .gold-gradient {
            background: linear-gradient(135deg, #FFD700, #FFA500);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            border-color: var(--accent);
        }

        .logo-animation {
            animation: logo-pulse 2s ease-in-out infinite;
        }

        @keyframes logo-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body class="bg-gray-50 scroll-smooth">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-black/95 backdrop-blur-md z-50 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <img src="https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614"
                        alt="AFBARBERSHOP Logo" class="h-10 w-auto logo-animation">
                    <span class="text-white font-display text-3xl font-bold tracking-wider">AFBARBERSHOP</span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-300 hover:text-accent transition-colors font-medium">Beranda</a>
                    <a href="#services"
                        class="text-gray-300 hover:text-accent transition-colors font-medium">Layanan</a>
                    <a href="#about" class="text-gray-300 hover:text-accent transition-colors font-medium">Tentang</a>
                    <a href="#gallery" class="text-gray-300 hover:text-accent transition-colors font-medium">Galeri</a>
                    <a href="#pricing" class="text-gray-300 hover:text-accent transition-colors font-medium">Harga</a>
                    <a href="#contact" class="text-gray-300 hover:text-accent transition-colors font-medium">Kontak</a>
                </div>

                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-black/95">
            <div class="px-4 py-4 space-y-3">
                <a href="#home" class="block text-gray-300 hover:text-accent transition-colors">Beranda</a>
                <a href="#services" class="block text-gray-300 hover:text-accent transition-colors">Layanan</a>
                <a href="#about" class="block text-gray-300 hover:text-accent transition-colors">Tentang</a>
                <a href="#gallery" class="block text-gray-300 hover:text-accent transition-colors">Galeri</a>
                <a href="#pricing" class="block text-gray-300 hover:text-accent transition-colors">Harga</a>
                <a href="#contact" class="block text-gray-300 hover:text-accent transition-colors">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://www.barberiaindonesia.com/uploads/1/4/4/3/144387242/published/grandindonesia3.png?1679159369"
                alt="Hero" class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>

        <div class="relative z-10 text-center text-white px-4 animate-fadeInUp">
            <div class="mb-8">
                <img src="https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614"
                    alt="AFBARBERSHOP Logo" class="h-24 w-auto mx-auto mb-6 logo-animation">
                <i class="fas fa-coffee text-4xl text-accent mb-4 inline-block ml-6 coffee-steam"></i>
            </div>
            <h1 class="font-display text-6xl md:text-8xl font-black mb-4 text-shadow tracking-wider">
                AFBARBERSHOP
            </h1>
            <p class="text-xl md:text-3xl mb-8 text-gray-200 font-serif">
                Premium Grooming Experience with Coffee
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="scrollToSection('booking')"
                    class="gold-gradient hover:shadow-2xl text-black font-bold py-4 px-10 rounded-full transition-all transform hover:scale-105 text-lg">
                    <i class="fas fa-calendar-check mr-2"></i>Booking Sekarang
                </button>
                <button onclick="scrollToSection('services')"
                    class="border-2 border-accent hover:bg-accent hover:text-black text-accent font-bold py-4 px-10 rounded-full transition-all text-lg">
                    <i class="fas fa-th-list mr-2"></i>Lihat Layanan
                </button>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-accent text-3xl"></i>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display text-5xl md:text-6xl font-black text-gray-900 mb-4">LAYANAN PREMIUM</h2>
                <p class="text-gray-600 text-xl font-serif">Grooming terbaik dengan sentuhan modern</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Main Barber Services -->
                <div class="md:col-span-2">
                    <div class="bg-black rounded-2xl p-8 hover-lift">
                        <div class="text-center mb-8">
                            <img src="https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614"
                                alt="AFBARBERSHOP Logo" class="h-16 w-auto mx-auto mb-4">
                            <h3 class="font-display text-4xl font-black text-white mb-2">BARBER SERVICES</h3>
                            <p class="text-gray-400 text-lg">Layanan grooming premium untuk pria modern</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div
                                class="bg-gray-900 rounded-xl p-5 card-hover border-2 border-transparent hover:border-white">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-scissors text-white text-2xl mr-4"></i>
                                        <div>
                                            <span class="text-white font-semibold text-lg">Signature Cut</span>
                                            <p class="text-gray-400 text-sm">Potongan premium</p>
                                        </div>
                                    </div>
                                    <span class="text-white font-bold text-xl">75K</span>
                                </div>
                            </div>

                            <div
                                class="bg-gray-900 rounded-xl p-5 card-hover border-2 border-transparent hover:border-white">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-beard text-white text-2xl mr-4"></i>
                                        <div>
                                            <span class="text-white font-semibold text-lg">Beard Design</span>
                                            <p class="text-gray-400 text-sm">Styling jenggot</p>
                                        </div>
                                    </div>
                                    <span class="text-white font-bold text-xl">60K</span>
                                </div>
                            </div>

                            <div
                                class="bg-gray-900 rounded-xl p-5 card-hover border-2 border-transparent hover:border-white">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-shower text-white text-2xl mr-4"></i>
                                        <div>
                                            <span class="text-white font-semibold text-lg">Royal Shave</span>
                                            <p class="text-gray-400 text-sm">Cukur premium</p>
                                        </div>
                                    </div>
                                    <span class="text-white font-bold text-xl">80K</span>
                                </div>
                            </div>

                            <div
                                class="bg-gray-900 rounded-xl p-5 card-hover border-2 border-transparent hover:border-white">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-crown text-white text-2xl mr-4"></i>
                                        <div>
                                            <span class="text-white font-semibold text-lg">VIP Package</span>
                                            <p class="text-gray-400 text-sm">Complete treatment</p>
                                        </div>
                                    </div>
                                    <span class="text-white font-bold text-xl">150K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coffee Services -->
                <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-2xl p-8 hover-lift">
                    <div class="text-center mb-6">
                        <i class="fas fa-coffee text-5xl text-secondary mb-4"></i>
                        <h3 class="font-display text-3xl font-black text-gray-900 mb-2">COFFEE CORNER</h3>
                        <p class="text-gray-600">Nikmati kopi premium</p>
                    </div>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <i class="fas fa-mug-hot text-secondary mr-3"></i>
                                <span class="text-gray-900 font-medium">Espresso</span>
                            </div>
                            <span class="text-secondary font-bold">25K</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <i class="fas fa-mug-hot text-secondary mr-3"></i>
                                <span class="text-gray-900 font-medium">Cappuccino</span>
                            </div>
                            <span class="text-secondary font-bold">35K</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <i class="fas fa-mug-hot text-secondary mr-3"></i>
                                <span class="text-gray-900 font-medium">Cold Brew</span>
                            </div>
                            <span class="text-secondary font-bold">40K</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-white rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <i class="fas fa-mug-hot text-secondary mr-3"></i>
                                <span class="text-gray-900 font-medium">AF Signature</span>
                            </div>
                            <span class="text-secondary font-bold">45K</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Packages -->
            <div class="bg-gradient-to-r from-black to-gray-900 rounded-2xl p-8 text-white">
                <h3 class="font-display text-3xl font-black text-accent mb-6 text-center">PAKET SPESIAL</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <i class="fas fa-gift text-4xl text-white mb-3"></i>
                        <h4 class="font-bold text-xl mb-2">Grooming Package</h4>
                        <p class="text-gray-400 mb-3">Cut + Beard + Shave</p>
                        <span class="text-3xl font-black text-white">180K</span>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-users text-4xl text-white mb-3"></i>
                        <h4 class="font-bold text-xl mb-2">Group Package</h4>
                        <p class="text-gray-400 mb-3">3+ Persons Discount</p>
                        <span class="text-3xl font-black text-white">-20%</span>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-star text-4xl text-white mb-3"></i>
                        <h4 class="font-bold text-xl mb-2">Member Package</h4>
                        <p class="text-gray-400 mb-3">Monthly Subscription</p>
                        <span class="text-3xl font-black text-white">500K</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <img src="https://picsum.photos/seed/afabout/600/500" alt="About" class="rounded-2xl shadow-2xl">
                    <div class="absolute -bottom-6 -right-6 bg-accent text-black rounded-xl p-4 shadow-xl">
                        <div class="text-center">
                            <div class="text-3xl font-black">15+</div>
                            <div class="font-semibold">Tahun Pengalaman</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="font-display text-5xl font-black text-gray-900 mb-6">TENTANG KAMI</h2>
                    <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                        AFBARBERSHOP adalah destinasi grooming premium yang telah melayani ribuan pelanggan sejak 2009.
                        Kami menggabungkan teknik traditional dengan modern styling untuk memberikan hasil terbaik.
                    </p>
                    <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                        Dengan tim barber profesional dan berpengalaman, kami berkomitmen untuk memberikan pengalaman
                        grooming yang tidak hanya membuat Anda tampil percaya diri, tetapi juga nyaman dan rileks.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="text-center bg-white rounded-lg p-4">
                            <i class="fas fa-award text-accent text-3xl mb-2"></i>
                            <div class="text-2xl font-black text-gray-900">10K+</div>
                            <div class="text-gray-600 text-sm">Pelanggan</div>
                        </div>
                        <div class="text-center bg-white rounded-lg p-4">
                            <i class="fas fa-cut text-accent text-3xl mb-2"></i>
                            <div class="text-2xl font-black text-gray-900">50K+</div>
                            <div class="text-gray-600 text-sm">Potongan</div>
                        </div>
                        <div class="text-center bg-white rounded-lg p-4">
                            <i class="fas fa-star text-accent text-3xl mb-2"></i>
                            <div class="text-2xl font-black text-gray-900">4.9</div>
                            <div class="text-gray-600 text-sm">Rating</div>
                        </div>
                    </div>

                    <button
                        class="gold-gradient hover:shadow-2xl text-black font-bold py-3 px-8 rounded-full transition-all transform hover:scale-105">
                        <i class="fas fa-play-circle mr-2"></i>Video Tour
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display text-5xl font-black text-gray-900 mb-4">GALERI KAMI</h2>
                <p class="text-gray-600 text-xl font-serif">Hasil kerja terbaik dari tim kami</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af1/400/400" alt="Gallery 1"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af2/400/400" alt="Gallery 2"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af3/400/400" alt="Gallery 3"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af4/400/400" alt="Gallery 4"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af5/400/400" alt="Gallery 5"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af6/400/400" alt="Gallery 6"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af7/400/400" alt="Gallery 7"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg group cursor-pointer">
                    <img src="https://picsum.photos/seed/af8/400/400" alt="Gallery 8"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display text-5xl font-black text-accent mb-4">TESTIMONI</h2>
                <p class="text-gray-400 text-xl font-serif">Apa kata pelanggan kami</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="text-gray-300 mb-4 italic">
                        "Barbershop terbaik yang pernah saya kunjungi! Hasil potongan selalu sesuai keinginan,
                        barber-nya profesional dan teliti."
                    </p>
                    <div class="flex items-center">
                        <img src="https://picsum.photos/seed/afuser1/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Rizky Hidayat</div>
                            <div class="text-gray-400 text-sm">Content Creator</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="text-gray-300 mb-4 italic">
                        "Tempatnya nyaman, pelayanannya top! Ditambah ada kopinya yang enak. Recommended banget untuk
                        grooming di sini!"
                    </p>
                    <div class="flex items-center">
                        <img src="https://picsum.photos/seed/afuser2/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Ahmad Fauzi</div>
                            <div class="text-gray-400 text-sm">Entrepreneur</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="text-gray-300 mb-4 italic">
                        "Sudah langganan 3 tahun di AFBARBERSHOP. Kualitasnya selalu konsisten, worth every penny!"
                    </p>
                    <div class="flex items-center">
                        <img src="https://picsum.photos/seed/afuser3/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Budi Santoso</div>
                            <div class="text-gray-400 text-sm">Professional</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="font-display text-5xl font-black text-gray-900 mb-4">BOOKING ONLINE</h2>
                    <p class="text-gray-600 text-xl font-serif">Reservasi mudah dan cepat</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-2xl">
                    <form onsubmit="handleBooking(event)">
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                                <input type="text" required
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                                    placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                                <input type="tel" required
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                                    placeholder="0812-3456-7890">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Pilih Layanan</label>
                                <select required
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors">
                                    <option value="">-- Pilih Layanan --</option>
                                    <option value="signature">Signature Cut (75K)</option>
                                    <option value="beard">Beard Design (60K)</option>
                                    <option value="shave">Royal Shave (80K)</option>
                                    <option value="vip">VIP Package (150K)</option>
                                    <option value="grooming">Grooming Package (180K)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tanggal</label>
                                <input type="date" required
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Waktu</label>
                                <select required
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors">
                                    <option value="">-- Pilih Waktu --</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="17:00">17:00</option>
                                    <option value="18:00">18:00</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Barber Pilihan</label>
                                <select
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors">
                                    <option value="">-- Bebas --</option>
                                    <option value="master1">Master Barber 1</option>
                                    <option value="master2">Master Barber 2</option>
                                    <option value="master3">Master Barber 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Catatan Tambahan</label>
                            <textarea rows="3"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                                placeholder="Permintaan khusus..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full gold-gradient hover:shadow-2xl text-black font-black py-4 rounded-lg transition-all transform hover:scale-105 text-lg">
                            <i class="fas fa-check-circle mr-2"></i>KONFIRMASI BOOKING
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-black">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="font-display text-5xl font-black text-accent mb-6">HUBUNGI KAMI</h2>
                    <p class="text-gray-400 mb-8 text-lg font-serif">
                        Kunjungi kami atau hubungi untuk informasi lebih lanjut
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-accent text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-white font-bold mb-1">Alamat</h3>
                                <p class="text-gray-400">Jl. Betoambari<br>Kota Baubau</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-phone text-accent text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-white font-bold mb-1">Telepon</h3>
                                <p class="text-gray-400">+62 852-2021-0003</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-envelope text-accent text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-white font-bold mb-1">Email</h3>
                                <p class="text-gray-400">info@afbarbershop.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-clock text-accent text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-white font-bold mb-1">Jam Buka</h3>
                                <p class="text-gray-400">Senin - Sabtu: 09:00 - 21:00<br>Minggu: 10:00 - 20:00</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-white font-bold mb-4">IKUTI KAMI</h3>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="bg-gray-800 hover:bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-800 hover:bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-800 hover:bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-800 hover:bg-accent text-white w-12 h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-gray-900 rounded-2xl p-8 border-2 border-accent">
                        <h3 class="text-accent font-display text-3xl font-black mb-6">KIRIM PESAN</h3>
                        <form onsubmit="handleContact(event)">
                            <div class="mb-4">
                                <input type="text" required
                                    class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent"
                                    placeholder="Nama Anda">
                            </div>
                            <div class="mb-4">
                                <input type="email" required
                                    class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent"
                                    placeholder="Email Anda">
                            </div>
                            <div class="mb-4">
                                <textarea rows="4" required
                                    class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent"
                                    placeholder="Pesan Anda"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full gold-gradient hover:shadow-2xl text-black font-black py-3 rounded-lg transition-all transform hover:scale-105">
                                <i class="fas fa-paper-plane mr-2"></i>KIRIM PESAN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-8 border-t border-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <img src="https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614"
                        alt="AFBARBERSHOP Logo" class="h-10 w-auto">
                    <span class="text-white font-display text-3xl font-black tracking-wider">AFBARBERSHOP</span>
                </div>
                <p class="text-gray-400 mb-4">© 2025 AFBARBERSHOP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6285220210003" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg transition-all transform hover:scale-110 z-40">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md mx-4 transform scale-95 transition-transform">
            <div class="text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-500 text-4xl"></i>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-2">BERHASIL!</h3>
                <p class="text-gray-600 mb-6" id="modalMessage">Permintaan Anda telah berhasil dikirim.</p>
                <button onclick="closeModal()"
                    class="gold-gradient hover:shadow-xl text-black font-black py-3 px-8 rounded-full transition-all">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Smooth Scroll
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.scrollIntoView({ behavior: 'smooth' });
        }

        // Navbar Scroll Effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-black');
                navbar.classList.remove('bg-black/95');
            } else {
                navbar.classList.add('bg-black/95');
                navbar.classList.remove('bg-black');
            }
        });

        // Handle Booking Form
        function handleBooking(event) {
            event.preventDefault();
            document.getElementById('modalMessage').textContent = 'Booking Anda telah berhasil dikonfirmasi. Kami akan menghubungi Anda segera.';
            showModal();
            event.target.reset();
        }

        // Handle Contact Form
        function handleContact(event) {
            event.preventDefault();
            document.getElementById('modalMessage').textContent = 'Pesan Anda telah berhasil dikirim. Kami akan membalas segera.';
            showModal();
            event.target.reset();
        }

        // Show Modal
        function showModal() {
            const modal = document.getElementById('successModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('div > div').classList.remove('scale-95');
                modal.querySelector('div > div').classList.add('scale-100');
            }, 10);
        }

        // Close Modal
        function closeModal() {
            const modal = document.getElementById('successModal');
            modal.querySelector('div > div').classList.remove('scale-100');
            modal.querySelector('div > div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Animate on Scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileMenu').classList.add('hidden');
            });
        });

        // Set minimum date for booking (today)
        const dateInput = document.querySelector('input[type="date"]');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }
    </script>
</body>

</html>