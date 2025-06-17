<div x-data="{ navbarOpen: false, dropdownOpen: false }" class="relative z-50">
    <!-- Navbar -->
    <div class="border-b-2 border-[#DBDBDB] bg-white fixed w-full top-0 left-0 z-50 lg:py-2 xl:py-1">
        <div class="container mx-auto py-5 px-5 flex items-center justify-between lg:px-24 xl:px-36">
            <div class="flex gap-14 items-center font-semibold text-base">
                <a href="/" wire:navigate><img src="{{ asset('logo2.svg') }}" alt="logo" class="w-24 xl:w-32"></a>
                <div class="relative group inline-block">
                    <!-- Trigger -->
                    <div class="gap-3 items-center cursor-pointer text-lg hidden lg:flex">
                        <p>Jelajahi</p>
                    </div>

                    <!-- Dropdown -->
                    <div
                        class="absolute top-full left-0 mt-12 bg-white border-2 border-[#DBDBDB] z-40 p-5 rounded-[25px] font-semibold grid grid-cols-2 gap-x-10 gap-y-4 w-[450px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-lg"
                    >
                    <a href="#masalah-umum">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-triangle-exclamation text-[#10B981]"></i>
                            <p>Masalah Umum</p>
                        </div>
                    </a>
                    <a href="#fitur-unggulan">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-star text-[#10B981]"></i>
                            <p>Fitur Unggulan</p>
                        </div>
                    </a>
                    <a href="#untuk-siapa">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-users text-[#10B981]"></i>
                            <p>Untuk Siapa?</p>
                        </div>
                    </a>
                    <a href="#testimoni">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-comments text-[#10B981]"></i>
                            <p>Testimoni</p>
                        </div>
                    </a>
                    <a href="#faq">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-circle-question text-[#10B981]"></i>
                            <p>FAQ</p>
                        </div>
                    </a>
                    <a href="#ayo-mulai">
                        <div class="flex items-center gap-3 text-lg hover:text-[#10B981] transition-colors">
                            <i class="fa-solid fa-rocket text-[#10B981]"></i>
                            <p>Ayo Mulai</p>
                        </div>
                    </a>
                    </div>
                </div>

            </div>

            <div class="font-semibold hidden gap-2 lg:flex">
                <button class="px-7 py-2 rounded-full hover:bg-[#DBDBDB]/20 transition-colors cursor-pointer xl:py-[14px]">Masuk</button>
                <button class="bg-[#1F2937] text-white px-7 py-2 rounded-full cursor-pointer hover:bg-[#10B981] transition-colors xl:py-[14px]">Daftar</button>
            </div>

            <button @click="navbarOpen = !navbarOpen" class="lg:hidden">
                <i :class="navbarOpen ? 'fa-xmark' : 'fa-bars'" class="fa-solid text-2xl text-[#1F2937] transition-all duration-300 ease-in-out"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar/Menu -->
    <div 
        x-show="navbarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-full opacity-0"
        class="fixed top-[81px] left-0 right-0 bottom-0 bg-white z-40 px-6 py-10 overflow-y-auto lg:hidden"
        style="display: none;"
    >
        <!-- Menu Content -->
        <div class="container mx-auto py-5 px-5 space-y-6 text-[#1F2937] font-semibold">
            <!-- Dropdown -->
            <div class="flex items-center justify-between font-semibold text-lg">
                <p>Jelajahi</p>
                <button @click="dropdownOpen = !dropdownOpen">
                    <i 
                        :class="[
                            'fa-solid',
                            dropdownOpen ? 'fa-chevron-up rotate-180' : 'fa-chevron-down rotate-0',
                            'transition-all duration-300 ease-in-out'
                        ]"
                    ></i>
                </button>
            </div>

            <!-- Dropdown Content -->
            <div 
                x-show="dropdownOpen" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="bg-[#DBDBDB]/20 px-4 py-5 rounded-xl flex flex-col text-sm"
            >
                <a href="#masalah-umum" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">Masalah Umum</a>
                <a href="#fitur-unggulan" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">Fitur Unggulan</a>
                <a href="#untuk-siapa" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">Untuk Siapa?</a>
                <a href="#testimoni" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">Testimoni</a>
                <a href="#faq" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">FAQ</a>
                <a href="#ayo-mulai" class="my-2 hover:underline" @click="navbarOpen = false; dropdownOpen = false">Ayo Mulai</a>
            </div>

            <!-- CTA Buttons -->
            <div class="py-3 px-3 text-center rounded-xl hover:bg-[#DBDBDB]/20 active:bg-[#DBDBDB]/20 transition-colors mt-10">
                <p @click="navbarOpen = false; dropdownOpen = false">Masuk</p>
            </div>
            <div class="bg-[#1F2937] text-white py-3 px-3 text-center rounded-xl active:bg-[#10B981] hover:bg-[#10B981] transition-colors">
                <p @click="navbarOpen = false; dropdownOpen = false">Daftar</p>
            </div>
        </div>
    </div>
</div>
