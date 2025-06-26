<div class="bg-gray-100 h-screen max-w-sm mx-auto block">
    <div class="bg-white rounded-b-3xl p-5 flex items-center justify-between">
        <a href="/akun"
            class="bg-slate-100 w-10 h-10 flex items-center justify-center rounded-2xl hover:bg-slate-200 transition">
            <i class="fa-solid fa-chevron-left text-xl text-gray-600"></i>
        </a>
        <h1 class="font-bold text-lg">Edit Profil</h1>
        <div class="w-8"></div>
    </div>

    <div class="px-5 mt-5">
        <div class="bg-white rounded-2xl p-5 space-y-5">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" role="alert"
                    class="alert alert-success mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" role="alert"
                    class="alert alert-error mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938-7.938a9 9 0 1112.728 12.728A9 9 0 015.07 7.07z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <p class="text-gray-600 text-sm">
                Perbarui data kamu di bawah ini. Pastikan <span class="font-semibold">nama</span> dan <span
                    class="font-semibold">email</span> yang digunakan sudah sesuai dan aktif.
            </p>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-600">Nama</label>
                <input wire:model="nama" type="text" placeholder="Masukkan nama lengkap kamu..."
                    class="w-full rounded-xl border border-[#10B981] focus:border-[#10B981] focus:ring-[#10B981] p-3 text-gray-700" />
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-gray-600">Email</label>
                <input wire:model="email" type="email" placeholder="Masukkan email aktif kamu..."
                    class="w-full rounded-xl border border-[#10B981] focus:border-[#10B981] focus:ring-[#10B981] p-3 text-gray-700" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-3">
                <button wire:click.prevent="update"
                    class="w-full rounded-xl bg-[#10B981] text-white font-bold p-3 hover:bg-[#0e9d75] active:scale-95 transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
