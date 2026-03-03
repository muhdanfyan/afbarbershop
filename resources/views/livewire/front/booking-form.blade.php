<div class="max-w-2xl mx-auto">
    @if($successMessage)
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center font-semibold">
            {{ $successMessage }}
        </div>
    @endif
    <form wire:submit.prevent="submit" class="space-y-4 md:space-y-6">
        <div class="grid md:grid-cols-2 gap-4 md:gap-6">
            <div>
                <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Nama Lengkap</label>
                <input type="text" wire:model="nama" required
                    class="w-full px-4 py-2 md:py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors text-sm md:text-base"
                    placeholder="Masukkan nama Anda">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Nomor Telepon</label>
                <input type="tel" wire:model="no_hp" required
                    class="w-full px-4 py-2 md:py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors text-sm md:text-base"
                    placeholder="0812-3456-7890">
                @error('no_hp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-4 md:gap-6">
            <div class="col-span-full">
                <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Pilih Tanggal & Waktu
                    Booking</label>
                <div class="relative">
                    <input type="datetime-local" wire:model.live="waktu_lengkap" required
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="w-full px-4 py-2 md:py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors text-sm md:text-base bg-white appearance-none">
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none pr-10">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                @error('waktu_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @error('waktu') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Pilih Layanan</label>
            <div class="service-grid grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                @foreach($jasaList as $item)
                    <label
                        class="relative service-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($layanan === $item->nama) border-accent ring-2 ring-accent @endif">
                        <input type="radio" wire:model.live="layanan" value="{{ $item->nama }}" class="sr-only" required>
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                class="w-10 h-10 md:w-14 md:h-14 rounded-full object-cover mb-2">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}" alt="{{ $item->nama }}"
                                class="w-10 h-10 md:w-14 md:h-14 rounded-full object-cover mb-2">
                        @endif
                        <span class="font-semibold text-gray-900 text-xs md:text-sm text-center">{{ $item->nama }}</span>
                        <span
                            class="text-[10px] md:text-xs text-gray-500">{{ number_format($item->harga, 0, ',', '.') }}K</span>
                    </label>
                @endforeach
            </div>
            @error('layanan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Barber Pilihan</label>
            <div class="staff-grid grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                <label
                    class="relative staff-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($barber === '' || $barber === null) border-accent ring-2 ring-accent @endif">
                    <input type="radio" wire:model.live="barber" value="" class="sr-only">
                    <img src="https://ui-avatars.com/api/?name=Bebas" alt="Bebas"
                        class="w-10 h-10 md:w-14 md:h-14 rounded-full object-cover mb-2">
                    <span class="font-semibold text-gray-900 text-xs md:text-sm">Bebas</span>
                </label>
                @foreach($kapsterList as $k)
                    <label
                        class="relative staff-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($barber === $k->nama) border-accent ring-2 ring-accent @endif">
                        <input type="radio" wire:model.live="barber" value="{{ $k->nama }}" class="sr-only">
                        @if($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                class="w-10 h-10 md:w-14 md:h-14 rounded-full object-cover mb-2">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}" alt="{{ $k->nama }}"
                                class="w-10 h-10 md:w-14 md:h-14 rounded-full object-cover mb-2">
                        @endif
                        <span class="font-semibold text-gray-900 text-xs md:text-sm">{{ $k->nama }}</span>
                    </label>
                @endforeach
            </div>
            @error('barber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            @if($barber && $estimasiTunggu > 0)
                <div class="mt-2 text-yellow-600 font-bold text-sm bg-yellow-50 p-2 rounded-lg border border-yellow-200">
                    <i class="fas fa-clock mr-1"></i> Estimasi Menunggu: {{ $estimasiTunggu }} Menit
                </div>
            @elseif($barber)
                <div class="mt-2 text-green-600 font-bold text-sm bg-green-50 p-2 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle mr-1"></i> Barber siap melayani (Tanpa Antrian)
                </div>
            @endif
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-1 md:mb-2 text-sm md:text-base">Catatan Tambahan</label>
            <textarea wire:model="catatan" rows="2 md:3"
                class="w-full px-4 py-2 md:py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors text-sm md:text-base"
                placeholder="Permintaan khusus..."></textarea>
            @error('catatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <button type="submit"
                class="w-full gold-gradient hover:shadow-2xl text-black font-black py-3 md:py-4 rounded-lg transition-all transform hover:scale-105 text-base md:text-lg">
                <i class="fas fa-check-circle mr-2"></i>KONFIRMASI BOOKING
            </button>
        </div>
    </form>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('bookingSuccess', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Berhasil!',
                        text: 'Kami akan menghubungi Anda.',
                        confirmButtonColor: '#FFD700',
                    });
                });
            });
        </script>
    @endpush
</div>