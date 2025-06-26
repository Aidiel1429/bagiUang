<div class="bg-gray-100 h-screen max-w-sm mx-auto block sm:hidden">
    <div class="bg-white rounded-b-3xl p-5 flex items-center justify-between">
        <a href="/dasbor">
            <div class="bg-slate-500/10 w-10 h-10 flex items-center justify-center rounded-2xl">
                <i class="fa-solid fa-chevron-left text-xl"></i>
            </div>
        </a>
        <h1 class="font-bold text-lg">Akun Saya</h1>
        <div class="w-8"></div>
    </div>

    <div class="px-5">
        <div class="bg-white rounded-3xl mt-3 p-5 flex flex-col items-center text-center">
            <div class="bg-slate-100 w-24 h-24 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-user-ninja text-3xl text-slate-600"></i>
            </div>
            <h2 class="mt-3 text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
            <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
        </div>

        <div class="mt-5 space-y-3">
            <a href="/akun/edit-profil"
                class="bg-white rounded-xl flex items-center justify-between p-4 hover:bg-slate-100 transition">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-user-pen text-slate-600"></i>
                    <span class="font-medium">Edit Profil</span>
                </div>
            </a>

            <a href="/akun/hapus-akun"
                class="bg-white rounded-xl flex items-center justify-between p-4 hover:bg-slate-100 transition">
                <div class="flex items-center space-x-3 text-red-600">
                    <i class="fa-solid fa-user-slash"></i>
                    <span class="font-medium">Hapus Akun</span>
                </div>
            </a>

            <livewire:auth.keluar/>
        </div>
    </div>

    {{-- mdoal hapus akun --}}
</div>
