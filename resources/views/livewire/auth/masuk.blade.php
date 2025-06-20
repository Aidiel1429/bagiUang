<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-emerald-600 text-center mb-2">BagiUang</h1>
        <h2 class="text-lg text-gray-800 text-center mb-6">Masuk untuk mulai atur keuanganmu</h2>

        @if (session()->has('success'))           
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show" 
                x-transition 
                role="alert" 
                class="alert alert-success mb-6 text-white"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
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

        <form wire:submit.prevent="masuk">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" wire:model="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4" x-data="{ show: false }">
                <label class="block text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input wire:model="password" :type="show ? 'text' : 'password'" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 pr-10">
                    
                    <span @click="show = !show"
                        class="absolute right-3 top-2.5 text-gray-500 hover:text-emerald-600 cursor-pointer text-lg">
                        <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fa-regular"></i>
                    </span>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end items-center mb-4">
                <a href="/forgot-password" class="text-sm text-emerald-600 hover:underline">Lupa password?</a>
            </div>

            <button 
                type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg shadow transition-colors cursor-pointer flex items-center justify-center gap-2"
                wire:loading.attr="disabled"
                wire:target="masuk"
            >
                <span wire:loading wire:target="masuk" class="loading loading-spinner loading-md"></span>
                <span wire:loading.remove wire:target="masuk">Masuk</span>
            </button>

        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun? <a href="/daftar" class="text-emerald-600 hover:underline">Daftar sekarang</a>
        </p>
    </div>
</div>