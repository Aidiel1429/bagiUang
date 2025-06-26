<div class="bg-[#F3F4F6] h-full min-h-screen max-w-sm container mx-auto pb-20" x-data="{ showFilter: false }">
    <div>
        <livewire:app.sidebar />
    </div>
    <div class="px-5 py-5">
        <div class="grid grid-cols-2 gap-2">
            <div class="bg-white p-3 rounded-2xl text-sm font-medium">
                <p class="text-center">Masuk</p>
                <p class="font-bold text-base mt-2 text-center">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded-2xl text-sm font-medium">
                <p class="text-center">Keluar</p>
                <p class="font-bold text-base mt-2 text-center">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white p-3 rounded-2xl text-sm font-medium mt-2">
            <p class="text-center">Sisa</p>
            <p class="font-bold text-base mt-2 text-center">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-2xl p-3 mt-4">
            <div class="flex items-center justify-between gap-3">
                <!-- Search Bar -->
                <div
                    class="relative flex items-center w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all">
                    <span class="text-gray-500 absolute left-3">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" wire:model.live="search" placeholder="Cari transaksi..."
                        class="w-full pl-10 outline-none" />
                </div>

                <button @click="showFilter = !showFilter">
                    <i class="fa-solid fa-list-ul text-xl"></i>
                </button>
            </div>
        </div>

        <div>
            @forelse ($riwayat as $item)
                <div class="bg-white rounded-2xl p-3 mt-3 mb-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-between space-x-3 w-full">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-slate-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid {{ $item->alokasi->icon }} text-base"></i>
                                </div>
                                <div class="flex flex-col max-w-[150px]">
                                    <p class="text-xs font-semibold">{{ $item->keterangan }}</p>
                                    <p class="text-xs">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <p class="text-xs font-semibold">
                                    <span>
                                        @if ($item->tipe == 'masuk')
                                            +
                                        @else
                                            -
                                        @endif
                                    </span> Rp. {{ number_format($item->jumlah, 0, ',', '.') }}
                                </p>
                                <p class="text-xs items-end">{{ $item->alokasi->nama }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex justify-center items-center w-full mt-4 bg-white rounded-2xl p-3 text-sm font-medium">
                    <p class="text-center">Tidak ada transaksi yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="z-40 h-screen fixed top-0 left-0 right-0 bottom-0 bg-black/20" x-show="showFilter"></div>

        <div class="fixed z-50 bg-white bottom-0 left-0 right-0 p-5 shadow-lg rounded-t-2xl" x-data="{ selectedRange: '' }"
            x-show="showFilter" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0" style="display: none;">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-bold">Filter Transaksi</h1>
                <button class="text-xl" @click="showFilter = !showFilter"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="mt-3 space-y-3">
                <div>
                    <h1 class="text-sm font-bold text-[#6e6e6e]">Rentang Waktu</h1>
                    <div class="px-3">
                        <div class="flex items-center justify-between mt-4 text-sm">
                            <label class="font-semibold">7 Hari Terakhir</label>
                            <input type="radio" name="radio-1" class="radio w-5 h-5" value="7_hari"
                                x-model="selectedRange" wire:model="temp_range"/>
                        </div>
                        <div class="flex items-center justify-between mt-4 text-sm">
                            <label class="font-semibold">Bulan Ini</label>
                            <input type="radio" name="radio-1" class="radio w-5 h-5" value="bulan_ini"
                                x-model="selectedRange" wire:model="temp_range"/>
                        </div>
                        <div class="flex items-center justify-between mt-4 text-sm">
                            <label class="font-semibold">Rentang Waktu</label>
                            <input type="radio" name="radio-1" class="radio w-5 h-5" value="custom"
                                x-model="selectedRange" />
                        </div>
                        <div x-show="selectedRange === 'custom'" x-transition class="mt-3">
                            <div class="flex flex-row justify-between gap-2">
                                <div class="flex flex-col flex-1">
                                    <label class="text-sm font-medium">Dari</label>
                                    <input wire:model="temp_tanggalAwal" type="date"
                                        class="mt-1 p-2 rounded-lg border border-gray-300 focus:border-[#10B981] outline-none text-sm" />
                                </div>
                                <div class="flex flex-col flex-1">
                                    <label class="text-sm font-medium">Sampai</label>
                                    <input wire:model="temp_tanggalAkhir" type="date"
                                        class="mt-1 p-2 rounded-lg border border-gray-300 focus:border-[#10B981] outline-none text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="text-sm font-bold text-[#6e6e6e]">Besar Transaksi</h1>
                    <div class="px-3">
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div x-data="{ aktif: false }" @click="aktif = true"
                                :class="aktif
                                    ?
                                    'bg-white border-2 border-[#10B981]' :
                                    'bg-slate-500/10 border-2 border-slate-500/10'"
                                class="rounded-2xl p-3 cursor-pointer transition-colors">
                                <p class="text-sm mb-1">Dari</p>
                                <div class="flex items-center">
                                    <span class="text-sm">Rp</span>
                                    <input wire:model="temp_minAmount" type="text" numeric
                                        class="w-full pl-1 outline-none bg-transparent text-sm" placeholder="0"
                                        @focus="aktif = true" @blur="aktif = false" />
                                </div>
                            </div>
                            <div x-data="{ aktif: false }" @click="aktif = true"
                                :class="aktif
                                    ?
                                    'bg-white border-2 border-[#10B981]' :
                                    'bg-slate-500/10 border-2 border-slate-500/10'"
                                class="rounded-2xl p-3 cursor-pointer transition-colors">
                                <p class="text-sm mb-1">Dari</p>
                                <div class="flex items-center">
                                    <span class="text-sm">Rp</span>
                                    <input wire:model="temp_maxAmount" type="text" numeric
                                        class="w-full pl-1 outline-none bg-transparent text-sm" placeholder="0"
                                        @focus="aktif = true" @blur="aktif = false" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="text-sm font-bold text-[#6e6e6e]">Alokasi</h1>
                    <div class="px-3">
                        <div class="mt-4">
                            <select class="select" wire:model="temp_alokasiId">
                                <option value="" selected>Pilih Alokasi</option>
                                @foreach ($listAlokasi as $item)                                    
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="text-sm font-bold text-[#6e6e6e]">Tipe Transaksi</h1>
                    <div class="px-3">
                        <div class="mt-4">
                            <select class="select" wire:model="temp_tipe">
                                <option value="" selected>Pilih Tipe</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-3 gap-3">
                    <button
                        wire:click="resetFilter"
                        x-on:click="showFilter = false"
                        class="bg-[#DBDBDB] text-black text-sm font-semibold rounded-lg px-3 py-2 hover:opacity-90">
                        Reset
                    </button>
                    <button
                        wire:click="applyFilter"
                        x-on:click="showFilter = false"
                        class="bg-[#10B981] text-white text-sm font-semibold rounded-lg px-3 py-2 hover:opacity-90">
                        Terapkan
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
