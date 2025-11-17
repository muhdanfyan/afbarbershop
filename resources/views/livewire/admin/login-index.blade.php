<!-- Login Container -->
<div class="relative z-10 w-full max-w-md mx-4">
    <div class="bg-black/90 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-800 overflow-hidden fade-in">

        <!-- Header -->
        <div class="text-center py-8 px-6 border-b border-gray-800">
            <div class="mb-4">
                <img src="https://z-cdn-media.chatglm.cn/files/af61646a-a1b8-42c2-8d3e-3d2ce670e9fa_LOGO_ABUABU.png?auth_key=1792272266-dc52cff157bc494aaa1cd27248585981-0-491798425db74ef70d988a044a386614"
                    alt="AF BARBERSHOP Logo" class="h-16 w-auto mx-auto mb-3">
            </div>
            <h1 class="font-display text-4xl font-black text-white mb-2">AF BARBERSHOP</h1>
            <p class="text-gray-400 font-serif">Premium Grooming Portal</p>
        </div>

        <!-- Login Form -->
        <div class="p-8">
            <form id="loginForm" wire:submit.prevent="login">
                <div class="mb-6 slide-up">
                    <label class="block text-gray-300 font-semibold mb-2">Email atau Username</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="username" required
                            class="w-full pl-12 pr-4 py-3 bg-gray-900 text-white rounded-xl border border-gray-700 focus:border-accent focus:outline-none input-gold transition-all"
                            placeholder="Masukkan email atau username" wire:model="email">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6 slide-up" style="animation-delay: 0.1s">
                    <label class="block text-gray-300 font-semibold mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="password" required
                            class="w-full pl-12 pr-12 py-3 bg-gray-900 text-white rounded-xl border border-gray-700 focus:border-accent focus:outline-none input-gold transition-all"
                            placeholder="Masukkan password" wire:model="password">
                        <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 password-toggle"
                            onclick="togglePassword()"></i>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" id="loginBtn"
                    class="w-full btn-gold text-black font-bold py-3 px-6 rounded-xl font-semibold transition-all slide-up"
                    style="animation-delay: 0.3s">
                    <span id="btnText">MASUK</span>
                    <div id="btnLoader" class="loading-spinner mx-auto hidden"></div>
                </button>
            </form>

        </div>
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-8">
        <a href="/" class="inline-flex items-center text-gray-400 hover:text-accent transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>
</div>