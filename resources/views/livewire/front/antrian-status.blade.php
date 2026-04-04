<div wire:poll.3s wire:key="antrian-status" id="antrian-status-root">
    <div class="bg-gray-50 dark:bg-gradient-to-r dark:from-black dark:to-gray-900 rounded-3xl p-4 md:p-8 text-gray-900 dark:text-white border border-gray-100 dark:border-white/5 shadow-2xl transition-all duration-500">
        <h3 class="font-display text-3xl md:text-4xl font-black text-accent mb-8 text-center uppercase tracking-wider">KAPSTER & STATUS ANTRIAN</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($kapsterStats as $k)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-5 md:p-6 card-hover border-2 border-transparent hover:border-accent text-center shadow-lg dark:shadow-none transition-all duration-300">
                    <div class="flex flex-col items-center mb-4">
                        @if($k['foto'])
                            <img src="{{ asset('storage/' . $k['foto']) }}" alt="{{ $k['nama'] }}"
                                class="h-16 w-16 md:h-20 md:w-20 rounded-full object-cover mb-3 border-2 border-accent/20 shadow-md">
                        @else
                            <div class="h-16 w-16 md:h-20 md:w-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
                                <i class="fas fa-user text-3xl md:text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        @endif
                        <span class="text-gray-900 dark:text-white font-black text-xl">{{ $k['nama'] }}</span>
                        @if (isset($k['sertifikat']) && $k['sertifikat'])
                            <a href="{{ asset('storage/' . $k['sertifikat']) }}" target="_blank"
                                class="mt-2 inline-flex items-center space-x-1 text-accent hover:underline transition-all">
                                <i class="fas fa-certificate text-xs"></i>
                                <span class="text-[10px] uppercase font-black tracking-widest">Verified Expert</span>
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mb-4">
                        <span class="bg-yellow-500/10 dark:bg-yellow-600/20 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-600/30 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                            Menunggu: <b>{{ $k['menunggu'] }}</b>
                        </span>
                        <span class="bg-blue-500/10 dark:bg-blue-600/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-600/30 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                            Proses: <b>{{ $k['proses'] }}</b>
                        </span>
                        <span class="bg-green-500/10 dark:bg-green-600/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-600/30 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                            Selesai: <b>{{ $k['selesai'] }}</b>
                        </span>
                    </div>
                    @if($k['estimasi'] > 0)
                        <div class="mt-2 p-2 bg-accent/10 rounded-lg text-accent font-black text-sm animate-pulse border border-accent/20">
                            <i class="fas fa-clock mr-1"></i> Estimasi Tunggu: {{ $k['estimasi'] }} mnt
                        </div>
                    @else
                        <div class="mt-2 p-2 bg-green-500/10 rounded-lg text-green-600 dark:text-green-400 font-black text-sm border border-green-500/20">
                            <i class="fas fa-check-circle mr-1"></i> Siap Melayani
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@push('scripts')
    <script>
        let lastAntrianStats = '';
        let bellAudio = null;
        function playBell() {
            if (!bellAudio) {
                bellAudio = new Audio('{{ asset('sound/soundbell.mp3') }}');
            }
            bellAudio.currentTime = 0;
            bellAudio.play().catch(() => {
                // Autoplay blocked, show test button
                document.getElementById('test-bell-btn').style.display = 'inline-block';
            });
        }
        document.addEventListener('livewire:update', function (e) {
            const antrianDiv = document.getElementById('antrian-status-root');
            if (antrianDiv) {
                const currentStats = antrianDiv.innerText;
                if (lastAntrianStats && lastAntrianStats !== currentStats) {
                    playBell();
                }
                lastAntrianStats = currentStats;
            }
        });
        // Tombol tes suara jika autoplay diblokir
        window.addEventListener('DOMContentLoaded', function () {
            if (!document.getElementById('test-bell-btn')) {
                const btn = document.createElement('button');
                btn.id = 'test-bell-btn';
                btn.textContent = 'Tes Suara Lonceng';
                btn.style = 'display:none;position:fixed;bottom:20px;right:20px;z-index:9999;padding:12px 18px;background:#FFD700;color:#222;border:none;border-radius:8px;font-weight:bold;box-shadow:0 2px 8px #0003;cursor:pointer;';
                btn.onclick = function () { playBell(); btn.style.display = 'none'; };
                document.body.appendChild(btn);
            }
        });
    </script>
@endpush