<div class="max-w-2xl mx-auto">
    @if($successMessage)
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center font-semibold">
            {{ $successMessage }}
        </div>
    @endif
    <form wire:submit.prevent="submit" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                <input type="text" wire:model.defer="nama" required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                    placeholder="Masukkan nama Anda">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                <input type="tel" wire:model.defer="no_hp" required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                    placeholder="0812-3456-7890">
                @error('no_hp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Tanggal</label>
                <input type="date" wire:model.defer="tanggal" required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors">
                @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Waktu</label>
                <select wire:model.defer="waktu" required
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
                @error('waktu') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Pilih Layanan</label>
            <div class="service-grid grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($jasaList as $item)
                    <label
                        class="relative service-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($layanan === $item->nama) border-accent ring-2 ring-accent @endif">
                        <input type="radio" wire:model.live="layanan" value="{{ $item->nama }}" class="sr-only" required>
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                class="w-14 h-14 rounded-full object-cover mb-2">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}" alt="{{ $item->nama }}"
                                class="w-14 h-14 rounded-full object-cover mb-2">
                        @endif
                        <span class="font-semibold text-gray-900">{{ $item->nama }}</span>
                        <span class="text-xs text-gray-500">{{ number_format($item->harga, 0, ',', '.') }}K</span>
                    </label>
                @endforeach
            </div>
            @error('layanan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-bold mb-2">Barber Pilihan</label>
            <div class="staff-grid grid grid-cols-2 md:grid-cols-3 gap-4">
                <label
                    class="relative staff-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($barber === '' || $barber === null) border-accent ring-2 ring-accent @endif">
                    <input type="radio" wire:model.live="barber" value="" class="sr-only">
                    <img src="https://ui-avatars.com/api/?name=Bebas" alt="Bebas"
                        class="w-14 h-14 rounded-full object-cover mb-2">
                    <span class="font-semibold text-gray-900">Bebas</span>
                </label>
                @foreach($kapsterList as $k)
                    <label
                        class="relative staff-card flex flex-col items-center cursor-pointer p-3 border-2 border-gray-200 rounded-xl transition hover:border-accent @if($barber === $k->nama) border-accent ring-2 ring-accent @endif">
                        <input type="radio" wire:model.live="barber" value="{{ $k->nama }}" class="sr-only">
                        @if($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}"
                                class="w-14 h-14 rounded-full object-cover mb-2">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}" alt="{{ $k->nama }}"
                                class="w-14 h-14 rounded-full object-cover mb-2">
                        @endif
                        <span class="font-semibold text-gray-900">{{ $k->nama }}</span>
                    </label>
                @endforeach
            </div>
            @error('barber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Catatan Tambahan</label>
            <textarea wire:model.defer="catatan" rows="3"
                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-accent focus:outline-none transition-colors"
                placeholder="Permintaan khusus..."></textarea>
            @error('catatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <button type="submit"
                class="w-full gold-gradient hover:shadow-2xl text-black font-black py-4 rounded-lg transition-all transform hover:scale-105 text-lg">
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