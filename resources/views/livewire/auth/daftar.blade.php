  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-emerald-600 text-center mb-2">BagiUang</h1>
        <h2 class="text-lg text-gray-800 text-center mb-6">Daftar & Mulai Atur Uangmu</h2>

        <form wire:submit.prevent="daftar">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" wire:model="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" wire:model="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ show: false }">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 pr-10" wire:model="password">
                        
                        <span @click="show = !show"
                            class="absolute right-3 top-2.5 text-gray-500 hover:text-emerald-600 cursor-pointer text-lg">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fa-regular"></i>
                        </span>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 pr-10" wire:model="password_confirmation">
                        
                        <span @click="show = !show"
                            class="absolute right-3 top-2.5 text-gray-500 hover:text-emerald-600 cursor-pointer text-lg">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fa-regular"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg shadow cursor-pointer flex items-center justify-center gap-2"
                wire:loading.attr="disabled"
                wire:target="daftar"
            >
                <span wire:loading wire:target="daftar" class="loading loading-spinner loading-md"></span>
                <span wire:loading.remove wire:target="daftar">Daftar Sekarang</span>
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun? <a href="/login" class="text-emerald-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>