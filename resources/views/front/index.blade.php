<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <link rel="shortcut icon"
        href="{{ isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : asset('logo-icon.png') }}"
        type="image/x-icon">

    <!-- Theme Detection Script (Early) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @stack('styles')
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 scroll-smooth">

    <!-- Scroll Progress Bar -->
    <div id="scroll-progress" class="fixed top-0 left-0 h-1 bg-accent z-[60] transition-all duration-150" style="width: 0%"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/90 dark:bg-black/90 backdrop-blur-lg z-50 transition-all duration-500 border-b border-black/5 dark:border-white/5" id="navbar">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2 md:space-x-3">
                    <img loading="lazy" decoding="async" src="{{ isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : 'https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614' }}"
                        alt="{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} Logo"
                        class="h-8 md:h-10 w-auto logo-animation theme-logo">
                    <!-- <span
                        class="text-white font-display text-2xl md:text-3xl font-bold tracking-wider">{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }}</span> -->
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Beranda</a>
                    <a href="#services"
                        class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Layanan</a>
                    <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Tentang</a>
                    <a href="#barbers" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Barber</a>
                    <a href="#gallery" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Galeri</a>
                    <a href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Harga</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-accent transition-colors font-medium">Kontak</a>
                    <div class="flex items-center bg-white/10 backdrop-blur-md rounded-full p-1 ml-4 border border-white/5" id="theme-toggle-container">
                        <button onclick="setTheme('light')" id="btn-light" class="w-8 h-8 flex items-center justify-center rounded-full transition-all duration-300 focus:outline-none" title="Light Mode">
                            <i class="fas fa-sun text-xs"></i>
                        </button>
                        <button onclick="setTheme('dark')" id="btn-dark" class="w-8 h-8 flex items-center justify-center rounded-full transition-all duration-300 focus:outline-none" title="Dark Mode">
                            <i class="fas fa-moon text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-4 md:hidden">
                    <div class="flex items-center bg-white/10 backdrop-blur-md rounded-full p-1 border border-white/5" id="theme-toggle-mobile-container">
                        <button onclick="setTheme('light')" id="btn-light-mobile" class="w-8 h-8 flex items-center justify-center rounded-full transition-all duration-300 focus:outline-none">
                            <i class="fas fa-sun text-xs"></i>
                        </button>
                        <button onclick="setTheme('dark')" id="btn-dark-mobile" class="w-8 h-8 flex items-center justify-center rounded-full transition-all duration-300 focus:outline-none">
                            <i class="fas fa-moon text-xs"></i>
                        </button>
                    </div>
                    <button class="text-gray-900 dark:text-white" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white/95 dark:bg-black/95 border-t border-black/10 dark:border-white/10 animate-fadeInUp">
            <div class="px-4 py-6 space-y-4">
                <a href="#home" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Beranda</a>
                <a href="#services" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Layanan</a>
                <a href="#about" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Tentang</a>
                <a href="#barbers" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Barber</a>
                <a href="#gallery" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Galeri</a>
                <a href="#pricing" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Harga</a>
                <a href="#contact" class="block text-gray-600 dark:text-gray-300 hover:text-accent transition-colors text-lg font-medium">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img loading="lazy" decoding="async" src="{{ asset('background.jpeg') }}" alt="Hero" class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>

        <div class="relative z-10 text-center px-4 animate-fadeInUp">
            <div class="mb-6 md:mb-8 text-center flex justify-center items-center">
                <img loading="lazy" decoding="async" src="{{ asset('/') }}logoposeidonputih.png"
                    alt="{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} Logo"
                    class="h-32 sm:h-40 md:h-64 lg:h-80 w-auto mx-auto mb-4 md:mb-6 logo-animation theme-logo">
            </div>
            
            <p class="text-lg md:text-3xl mb-8 text-gray-900 dark:text-gray-200 font-serif text-shadow">
                {{ $settings['slogan'] ?? 'Premium Grooming Experience with Coffee' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="scrollToSection('booking')"
                    class="gold-gradient hover:shadow-2xl hover:shadow-yellow-500/40 text-black font-black py-4 md:py-5 px-10 md:px-14 rounded-full transition-all transform hover:scale-110 text-base md:text-xl tracking-wide uppercase shadow-lg shadow-yellow-400/30">
                    <i class="fas fa-calendar-check mr-2"></i>Booking Sekarang
                </button>
                <button onclick="scrollToSection('services')"
                    class="bg-white/10 dark:bg-white/20 backdrop-blur-sm border-2 border-gray-900 dark:border-white text-gray-950 dark:text-white font-black py-4 md:py-5 px-10 md:px-14 rounded-full transition-all text-base md:text-xl tracking-wide uppercase shadow-lg hover:shadow-white/30">
                    <i class="fas fa-th-list mr-2"></i>Lihat Layanan
                </button>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-accent text-3xl"></i>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-12 md:py-20 bg-white dark:bg-gray-950 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase">LAYANAN PREMIUM</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl font-serif">Grooming terbaik dengan sentuhan modern</p>
            </div>

            <div class="bg-gradient-to-r from-gray-50 to-white dark:from-black dark:to-gray-900 rounded-2xl p-4 md:p-8 text-gray-900 dark:text-white border border-gray-100 dark:border-white/5 shadow-xl transition-all duration-500">
                <!-- Main Barber Services -->
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-black rounded-2xl p-4 md:p-8 hover-lift border border-gray-100 dark:border-white/5 shadow-lg">
                        <div class="text-center mb-6 md:mb-8">
                            <img loading="lazy" decoding="async" src="{{ isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : 'https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614' }}"
                                alt="{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} Logo"
                                class="h-12 md:h-16 w-auto mx-auto mb-4 theme-logo">
                            <h3 class="font-display text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2 uppercase">BARBER SERVICES
                            </h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-3 md:gap-4">
                            @foreach($jasa as $item)
                                <div
                                    class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 md:p-5 card-hover border-2 border-gray-100 dark:border-transparent hover:border-accent animate-fadeInUp">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($item->foto)
                                                <img loading="lazy" decoding="async" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                                    class="h-8 w-8 md:h-10 md:w-10 rounded-full mr-3 md:mr-4 object-cover">
                                            @else
                                                <i class="fas fa-scissors text-gray-400 dark:text-white text-xl md:text-2xl mr-3 md:mr-4"></i>
                                            @endif
                                            <div>
                                                <span
                                                    class="text-gray-900 dark:text-white font-semibold text-base md:text-lg block">{{ $item->nama }}</span>
                                                <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm line-clamp-1">
                                                    {{ $item->deskripsi }}
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-gray-900 dark:text-white font-bold text-lg md:text-xl ml-2">{{ number_format($item->harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-12 md:py-20 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase tracking-tight">PRODUK KAMI</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl font-serif">Koleksi perawatan rambut premium</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @forelse($barangs ?? [] as $barang)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover-lift border border-gray-100 dark:border-white/5 transition-all duration-500">
                        <div class="aspect-square relative flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                            @if($barang->foto)
                                <img loading="lazy" decoding="async" src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-box text-4xl text-gray-300 dark:text-gray-500"></i>
                            @endif
                            
                            @if($barang->stok < 5)
                                <div class="absolute top-2 right-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                                    STOK TERBATAS: {{ $barang->stok }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm md:text-base line-clamp-1 mb-1">{{ $barang->nama }}</h3>
                            <div class="text-accent font-black text-base md:text-lg">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 italic">Stok: {{ $barang->stok }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">Belum ada produk tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Antrian Section -->
    <section id="antrian" class="py-12 md:py-20 bg-gray-50 dark:bg-black transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase">ANTRIAN PELANGGAN</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl font-serif">Pantau status antrian secara real-time</p>
            </div>
            @livewire('front.antrian-status')
        </div>
    </section>


    <!-- About Section -->
    <!-- <section id="about" class="py-12 md:py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="relative order-2 md:order-1">
                    <img loading="lazy" decoding="async" src="https://picsum.photos/seed/afabout/600/500" alt="About"
                        class="rounded-2xl shadow-2xl w-full h-auto">
                    <div
                        class="absolute -bottom-6 -right-6 bg-accent text-black rounded-xl p-4 shadow-xl hidden md:block">
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <h2 class="font-display text-4xl md:text-5xl font-black text-accent mb-6 leading-tight uppercase">TENTANG KAMI</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-base md:text-lg leading-relaxed">
                        {{ $settings['deskripsi'] ?? 'Barbershop premium dengan pelayanan terbaik untuk penampilan maskulin Anda.' }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg leading-relaxed">
                        Kami mengutamakan kualitas potongan rambut dan kenyamanan pelanggan dengan sentuhan modern dan
                        profesional.
                    </p>AFBARBERSHOP' }} didirikan sebagai bentuk dedikasi kami kepada
                        kaum pria yang ingin mendapatkan experience dan
                        penampilan terbaik. Kami berusaha sepenuh hati memberikan layanan terbaik dengan suasana hangat,
                        nyaman melalui
                        tangan-tangan profesional yang selalu dapat diandalkan.
                    </p>


                </div>
            </div>
        </div>
    </section> -->

    <!-- Barbers Section -->
    <section id="barbers" class="py-12 md:py-20 bg-white dark:bg-gray-950 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase">OUR BARBERS</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl font-serif">Tangan-tangan profesional yang siap melayani anda
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($kapsters as $kapster)
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg hover-lift border border-gray-100 dark:border-white/5 transition-all duration-500">
                        <div class="aspect-[4/5] relative">
                            @if($kapster->foto)
                                <img loading="lazy" decoding="async" src="{{ asset('storage/' . $kapster->foto) }}" alt="{{ $kapster->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-6xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="font-display text-3xl font-black text-gray-900 dark:text-white">{{ $kapster->nama }}</h3>
                            @if($kapster->sertifikat)
                                <button type="button"
                                    onclick="showCertificate('{{ asset('storage/' . $kapster->sertifikat) }}')"
                                    class="mt-3 inline-flex items-center space-x-2 bg-accent text-black px-4 py-2 rounded-full text-sm font-bold transition-all hover:bg-black hover:text-white">
                                    <i class="fas fa-certificate"></i>
                                    <span>LIHAT SERTIFIKAT</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white dark:bg-gray-950 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase underline decoration-accent decoration-4 underline-offset-8">GALERI KAMI</h2>
                <p class="text-gray-600 dark:text-gray-400 text-xl font-serif">Hasil kerja terbaik dari tim kami</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($galleries as $gallery)
                    <div class="relative overflow-hidden rounded-lg group cursor-pointer aspect-square">
                        @if ($gallery->type == 'image')
                            <img loading="lazy" decoding="async" src="{{ asset('storage/' . $gallery->file) }}" alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 text-center">
                                <i class="fas fa-search-plus text-white text-3xl mb-2"></i>
                                @if ($gallery->title)
                                    <span class="text-white font-bold">{{ $gallery->title }}</span>
                                @endif
                            </div>
                        @else
                            <video src="{{ asset('storage/' . $gallery->file) }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"></video>
                            <div
                                class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/60 transition-all duration-300">
                                <i class="fas fa-play-circle text-white text-5xl"></i>
                            </div>
                            <div
                                class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end p-4 text-center bg-gradient-to-t from-black/80 to-transparent">
                                @if ($gallery->title)
                                    <span class="text-white font-bold">{{ $gallery->title }}</span>
                                @endif
                                <span class="text-gray-300 text-xs">Video</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <!-- <section class="py-20 bg-black">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-display text-5xl text-white text-accent mb-4">TESTIMONI</h2>
                <p class="text-gray-400 text-xl font-serif">Apa kata pelanggan kami</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4  text-white ">
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
                        <img loading="lazy" decoding="async" src="https://picsum.photos/seed/afuser1/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Rizky Hidayat</div>
                            <div class="text-gray-400 text-sm">Content Creator</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4  text-white ">
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
                        <img loading="lazy" decoding="async" src="https://picsum.photos/seed/afuser2/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Ahmad Fauzi</div>
                            <div class="text-gray-400 text-sm">Entrepreneur</div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 hover-lift border-2 border-transparent hover:border-accent">
                    <div class="flex mb-4  text-white ">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="text-gray-300 mb-4 italic">
                        "Sudah langganan 3 tahun di {{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }}. Kualitasnya selalu
                        konsisten, worth every penny!"
                    </p>
                    <div class="flex items-center">
                        <img loading="lazy" decoding="async" src="https://picsum.photos/seed/afuser3/50/50" alt="User"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="text-white font-semibold">Budi Santoso</div>
                            <div class="text-gray-400 text-sm">Professional</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Booking Section -->
    <section id="booking" class="py-12 md:py-20 bg-gray-50 dark:bg-gray-900 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-10 md:mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-2 uppercase">BOOKING ONLINE</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl font-serif">Reservasi mudah dan cepat</p>
            </div>

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl">
                    @livewire('front.booking-form')
                </div>
            </div>
        </div>
    </section>

    <!--- `[x]` Implement full color inversion CSS logic in `app.css`
- `[x]` Update Navbar and Mobile Menu for Light/Dark inversion
- `[x]` Apply logo brightness/contrast filter for Light Mode
- `[x]` Invert Services Section (gradient container and cards)
- `[x]` Update About, Barbers, and Gallery sections for consistent inversion
- `[x]` Update Contact Section and Footer for Light Mode background
- `[x]` Audit and update `booking-form` Livewire component theaming
- `[/]` Final rebuild and cache clear
- `[ ]` Verification with browser subagent-->
    <section id="contact" class="py-12 md:py-20 bg-white dark:bg-black transition-colors duration-500 border-t border-gray-100 dark:border-transparent">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10 md:gap-12">
                <div>
                    <h2 class="font-display text-4xl md:text-5xl font-black text-accent mb-6">HUBUNGI KAMI</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-base md:text-lg font-serif">
                        Kunjungi kami atau hubungi untuk informasi lebih lanjut
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-accent text-lg md:text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-gray-900 dark:text-white font-bold mb-1 border-b-2 border-accent/20 inline-block">Alamat</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">
                                    {!! nl2br(e($settings['alamat'] ?? '')) !!}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-phone text-accent text-lg md:text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-gray-900 dark:text-white font-bold mb-1 border-b-2 border-accent/20 inline-block">Telepon</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">{{ $settings['telepon'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-envelope text-accent text-lg md:text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-gray-900 dark:text-white font-bold mb-1 border-b-2 border-accent/20 inline-block">Email</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">{{ $settings['email'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-clock text-accent text-lg md:text-xl mr-4 mt-1"></i>
                            <div>
                                <h3 class="text-gray-900 dark:text-white font-bold mb-1 border-b-2 border-accent/20 inline-block">Jam Buka</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">
                                    {!! nl2br(e($settings['jam_buka'] ?? '')) !!}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 md:mt-12">
                        <h3 class="text-gray-900 dark:text-white font-bold mb-4">IKUTI KAMI</h3>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="bg-gray-100 dark:bg-gray-800 hover:bg-accent text-gray-900 dark:text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110 shadow-sm">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-100 dark:bg-gray-800 hover:bg-accent text-gray-900 dark:text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110 shadow-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-100 dark:bg-gray-800 hover:bg-accent text-gray-900 dark:text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110 shadow-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                                class="bg-gray-100 dark:bg-gray-800 hover:bg-accent text-gray-900 dark:text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all transform hover:scale-110 shadow-sm">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 md:mt-0">
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 md:p-8 border-2 border-accent/30 dark:border-accent shadow-xl">
                        <h3 class="text-accent font-display text-2xl md:text-3xl font-black mb-6">KIRIM PESAN</h3>
                        <form onsubmit="handleContact(event)">
                            <div class="mb-4">
                                <input type="text" required
                                    class="w-full px-4 py-2 md:py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-transparent placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent text-sm md:text-base shadow-sm"
                                    placeholder="Nama Anda">
                            </div>
                            <div class="mb-4">
                                <input type="email" required
                                    class="w-full px-4 py-2 md:py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-transparent placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent text-sm md:text-base shadow-sm"
                                    placeholder="Email Anda">
                            </div>
                            <div class="mb-4">
                                <textarea rows="4" required
                                    class="w-full px-4 py-2 md:py-3 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-transparent placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent text-sm md:text-base shadow-sm"
                                    placeholder="Pesan Anda"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full gold-gradient hover:shadow-2xl text-black font-black py-2 md:py-3 rounded-lg transition-all transform hover:scale-105 text-sm md:text-base">
                                <i class="fas fa-paper-plane mr-2"></i>KIRIM PESAN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-black py-8 border-t border-gray-200 dark:border-gray-800 transition-colors duration-500">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <img loading="lazy" decoding="async" src="{{ isset($settings['logo']) && $settings['logo'] ? asset('storage/' . $settings['logo']) : 'https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614' }}"
                        alt="{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }} Logo" class="h-10 w-auto theme-logo">
                    <span
                        class="text-gray-900 dark:text-white font-display text-3xl font-black tracking-wider uppercase">{{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }}</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-4 font-medium">© 2025 {{ $settings['nama_usaha'] ?? 'AFBARBERSHOP' }}. All rights
                    reserved.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/{{ $settings['telepon'] ?? '6285220210003' }}" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg transition-all transform hover:scale-110 z-40">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50 transition-all duration-500">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 max-w-md mx-4 transform scale-95 transition-all shadow-2xl border border-gray-100 dark:border-white/5">
            <div class="text-center">
                <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-500 dark:text-green-400 text-4xl"></i>
                </div>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-2">BERHASIL!</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6" id="modalMessage">Permintaan Anda telah berhasil dikirim.</p>
                <button onclick="closeModal()"
                    class="gold-gradient hover:shadow-xl text-black font-black py-3 px-8 rounded-full transition-all w-full">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Certificate Modal -->
    <div id="certificateModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[60] p-4 transition-all duration-500">
        <div
            class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden w-full max-w-4xl max-h-[90vh] flex flex-col relative transform scale-95 transition-all shadow-2xl border border-gray-100 dark:border-white/5">
            <button onclick="closeCertificate()"
                class="absolute top-4 right-4 text-gray-900 dark:text-white bg-white/80 dark:bg-black/80 hover:bg-white dark:hover:bg-black w-10 h-10 rounded-full flex items-center justify-center transition-all z-10 shadow-lg">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="certificateContent" class="flex-grow overflow-auto bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <!-- Content injected here -->
            </div>
            <div class="p-4 bg-white dark:bg-gray-900 text-center border-t border-gray-100 dark:border-gray-800 transition-colors">
                <a id="downloadCert" href="#" download
                    class="inline-flex items-center space-x-2 text-primary dark:text-accent font-bold hover:text-accent dark:hover:text-white transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    <span>SIMPAN SERTIFIKAT</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Dark / Light Mode Toggle (Radio Style)
        function setTheme(mode) {
            const html = document.documentElement;
            if (mode === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            localStorage.setItem('theme', mode);
            updateThemeUI(mode);
            console.log('Theme set to:', mode);
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            setTheme(isDark ? 'light' : 'dark');
        }

        function updateThemeUI(mode) {
            if (!mode) {
                mode = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            }
            
            const btnLight = document.getElementById('btn-light');
            const btnDark = document.getElementById('btn-dark');
            const btnLightM = document.getElementById('btn-light-mobile');
            const btnDarkM = document.getElementById('btn-dark-mobile');
            
            if (mode === 'dark') {
                // Desktop
                btnDark?.classList.add('bg-accent', 'text-black', 'shadow-inner');
                btnDark?.classList.remove('text-gray-400');
                btnLight?.classList.remove('bg-accent', 'text-black', 'shadow-inner');
                btnLight?.classList.add('text-gray-400');
                
                // Mobile
                btnDarkM?.classList.add('bg-accent', 'text-black', 'shadow-inner');
                btnDarkM?.classList.remove('text-gray-400');
                btnLightM?.classList.remove('bg-accent', 'text-black', 'shadow-inner');
                btnLightM?.classList.add('text-gray-400');
            } else {
                // Desktop
                btnLight?.classList.add('bg-accent', 'text-black', 'shadow-inner');
                btnLight?.classList.remove('text-gray-400');
                btnDark?.classList.remove('bg-accent', 'text-black', 'shadow-inner');
                btnDark?.classList.add('text-gray-400');
                
                // Mobile
                btnLightM?.classList.add('bg-accent', 'text-black', 'shadow-inner');
                btnLightM?.classList.remove('text-gray-400');
                btnDarkM?.classList.remove('bg-accent', 'text-black', 'shadow-inner');
                btnDarkM?.classList.add('text-gray-400');
            }
        }

        // Initialize icons on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            updateThemeUI();
        });

        // Also check on window load just in case
        window.addEventListener('load', () => {
            updateThemeUI();
        });

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

        // Handle Booking Form (AJAX)
        document.getElementById('bookingForm').addEventListener('submit', async function (event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            try {
                const response = await fetch('/booking', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('modalMessage').textContent = 'Booking Anda telah berhasil dikonfirmasi. Kami akan menghubungi Anda segera.';
                    showModal();
                    form.reset();
                } else {
                    alert(data.message || 'Terjadi kesalahan.');
                }
            } catch (e) {
                alert('Terjadi kesalahan saat mengirim booking.');
            }
        });

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

        // --- Certificate Modal Functions ---
        function showCertificate(url) {
            const modal = document.getElementById('certificateModal');
            const content = document.getElementById('certificateContent');
            const downloadLink = document.getElementById('downloadCert');

            downloadLink.href = url;

            // Cek jika file adalah PDF (berdasarkan ekstensi)
            const isPdf = url.toLowerCase().endsWith('.pdf');

            if (isPdf) {
                content.innerHTML = `<iframe src="${url}" class="w-full h-[70vh]" frameborder="0"></iframe>`;
            } else {
                content.innerHTML = `<img loading="lazy" decoding="async" src="${url}" class="max-w-full max-h-[70vh] object-contain" alt="Sertifikat">`;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('div > div').classList.remove('scale-95');
                modal.querySelector('div > div').classList.add('scale-100');
            }, 10);
        }

        function closeCertificate() {
            const modal = document.getElementById('certificateModal');
            modal.querySelector('div > div').classList.remove('scale-100');
            modal.querySelector('div > div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('certificateContent').innerHTML = ''; // Clear content on close
            }, 200);
        }

        // Animate on Scroll
        // Scroll Progress
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("scroll-progress").style.width = scrolled + "%";
        });

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

    @stack('scripts')

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('transaksi-updated', () => {
                Livewire.emit('refresh');
            });
        });
    </script>

    @livewireScripts
</body>

</html>