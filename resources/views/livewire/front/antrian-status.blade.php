<div wire:poll.3s wire:key="antrian-status" id="antrian-status-root">
    <div class="bg-gradient-to-r from-black to-gray-900 rounded-2xl p-4 md:p-8 text-white">
        <h3 class="font-display text-3xl font-black text-accent mb-6 text-center">KAPSTER & STATUS ANTRIAN</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($kapsterStats as $k)
                <div
                    class="bg-gray-900 rounded-xl p-4 md:p-5 card-hover border-2 border-transparent hover:border-accent text-center">
                    <div class="flex flex-col items-center mb-3">
                        @if($k['foto'])
                            <img src="{{ asset('storage/' . $k['foto']) }}" alt="{{ $k['nama'] }}"
                                class="h-14 w-14 md:h-16 md:w-16 rounded-full object-cover mb-2">
                        @else
                            <i class="fas fa-user text-3xl md:text-4xl text-white mb-2"></i>
                        @endif
                        <span class="text-white font-semibold text-lg">{{ $k['nama'] }}</span>
                        @if (isset($k['sertifikat']) && $k['sertifikat'])
                            <a href="{{ asset('storage/' . $k['sertifikat']) }}" target="_blank"
                                class="mt-1 inline-flex items-center space-x-1 text-accent hover:text-white transition-colors">
                                <i class="fas fa-certificate text-xs"></i>
                                <span class="text-[10px] uppercase font-bold tracking-tighter">Verified Certificate</span>
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 text-xs md:text-sm">
                        <span class="bg-yellow-600 px-2 py-1 rounded-full whitespace-nowrap">Menunggu:
                            <b>{{ $k['menunggu'] }}</b></span>
                        <span class="bg-blue-600 px-2 py-1 rounded-full whitespace-nowrap">Proses:
                            <b>{{ $k['proses'] }}</b></span>
                        <span class="bg-green-600 px-2 py-1 rounded-full whitespace-nowrap">Selesai:
                            <b>{{ $k['selesai'] }}</b></span>
                    </div>
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