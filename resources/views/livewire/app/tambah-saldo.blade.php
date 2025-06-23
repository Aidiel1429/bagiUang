<div class="container mx-auto max-w-sm px-5 py-5">
    <a href="/alokasi">
        <div class="bg-slate-500/10 w-10 h-10 flex items-center justify-center rounded-2xl mb-5">
            <i class="fa-solid fa-chevron-left text-xl"></i>
        </div>
    </a>
    <div class="">
        <h1 class="text-xl font-bold text-center">Tambah Saldo</h1>
        @if (session()->has('error'))           
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show" 
                x-transition 
                role="alert" 
                class="alert alert-error mb-6 text-white"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        <form class="mt-5">
            <div>
                <label class="label">Jumlah Saldo</label>
                <div class="relative flex items-center mt-2 w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all">
                    <span class="text-gray-500 absolute left-3">Rp.</span>
                    <input type="number" wire:model="jumlah" class="w-full pl-10 outline-none"/>
                </div>
                @error('jumlah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-5">
                <label class="label">Tanggal</label>
                <input type="date" wire:model="tanggal" class="px-3 py-2 mt-2 w-full border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all" />
                @error('tanggal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-5">
                <label class="label">Keterangan</label>
                <textarea wire:model="keterangan" class="px-3 py-2 mt-2 w-full border-2 border-gray-300 outline-[#10B981] rounded-lg focus-within:border-[#10B981] transition-all"></textarea>
                @error('keterangan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-5">
            <button 
                type="button"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg shadow transition-colors cursor-pointer flex items-center justify-center gap-2"
                onclick="document.getElementById('modalTambah').showModal()"
            >
                <span >Tambah Saldo</span>
            </button>
            </div>
        </form>
    </div>

    <dialog id="modalTambah" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Informasi Saldo</h3>
            <p class="py-4">
                Saat kamu menambahkan saldo, sistem akan secara otomatis membagi saldo tersebut ke 
                semua alokasi selain alokasi utama sesuai dengan persentase yang telah kamu tentukan. 
                Jika total persentase alokasi tidak 100%, maka sisa saldo akan masuk ke alokasi utama.
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Tutup</button>
                    <button class="btn btn-active btn-success text-white" wire:click="store">Tambah Saldo</button>
                </form>
            </div>
        </div>
    </dialog>
</div>
