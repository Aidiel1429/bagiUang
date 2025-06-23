<div class="container mx-auto max-w-sm bg-[#F3F4F6]">
    <div class=" px-5 py-5">
        <div class="flex items-center justify-between mb-5">
            <a href="/dasbor">
                <div class="bg-slate-500/10 w-10 h-10 flex items-center justify-center rounded-2xl">
                    <i class="fa-solid fa-chevron-left text-xl"></i>
                </div>
            </a>
    
            <div class="dropdown dropdown-end">
                <div 
                    tabindex="0" 
                    role="button"
                    class="{{ $dataAlokasi->nama == 'Alokasi Utama' ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}" 
                    @if($dataAlokasi->nama == 'Alokasi Utama') aria-disabled="true" @endif
                >
                    <button 
                        class="bg-slate-500/10 w-10 h-10 flex items-center justify-center rounded-2xl"
                        {{ $dataAlokasi->nama == 'Alokasi Utama' ? 'disabled' : '' }}
                    >
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                </div>

                @unless($dataAlokasi->nama == 'Alokasi Utama')
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                        <li><a>Hapus Kantong</a></li>
                        <li><a>Edit Kantong</a></li>
                    </ul>
                @endunless
            </div>

        </div>
        <div class="text-center">
            <i class="fa-solid {{ $dataAlokasi->icon }} text-3xl text-[#10B981]"></i>
            <h1 class="mt-2 font-extrabold text-xl">{{ $dataAlokasi->nama }}</h1>
            <p class="mt-1 text-xl font-bold text-[#4c4c4c]">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
        </div>
        <div class="flex justify-center gap-10 mt-5">
            <div class="text-center flex flex-col justify-center items-center">
                <button 
                    class="flex items-center justify-center 
                        w-10 h-10 rounded-full text-white 
                        {{ $hanyaAlokasiUtama ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#10B981]' }}" 
                    @if(!$hanyaAlokasiUtama) 
                        wire:click="openPindahSaldoModal"
                        onClick="document.getElementById('pindahkanSaldo').showModal()"
                    @endif
                    @if($hanyaAlokasiUtama) disabled @endif
                >
                    <i class="fa-solid fa-right-left"></i>
                </button>
                <p class="text-sm font-semibold mt-2">Pindahkan Saldo</p>
            </div>


            <div class="text-center flex flex-col justify-center items-center">
                <button 
                    class="flex items-center justify-center w-10 h-10 rounded-full text-white 
                        {{ $totalSaldo == 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#10B981]' }}" 
                    @if($totalSaldo == 0) disabled @endif
                >
                    <i class="fa-solid fa-money-bill-wave"></i>
                </button>
                <p class="text-sm font-semibold mt-2">Transfer & Bayar</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-t-3xl p-5">
        <div class="flex items-center justify-between gap-8 mb-5">
            <div class="relative flex items-center mt-2 w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all">
                <span class="text-gray-500 absolute left-3"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="number" wire:model="jumlah" class="w-full pl-10 outline-none"/>
            </div>
        </div>

        <div class="mt-5">
            <div>
                @forelse ($riwayat_alokasi as $item)
                    <div class="bg-white rounded-2xl flex items-center justify-between mt-3">
                        <div class="flex items-center gap-5">
                            <i class="fa-solid {{ $item->alokasi->icon }} text-xl"></i>
                            <div>
                                <p class="text-sm font-semibold">{{ $item->keterangan }}</p>
                                <p class="text-xs">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-sm font-semibold">@if ($item->tipe == 'masuk')
                                +
                            @else
                                -
                            @endif Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                            <p class="text-xs items-end">{{ $item->alokasi->nama }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada transaksi.</p>
                @endforelse
            </div>
        </div>
    </div>

    <dialog id="pindahkanSaldo" class="modal" wire:ignore.self>
        <div class="modal-box">
            <h3 class="text-lg font-bold">Pindahkan Saldo!</h3>
            <form class="mt-3" wire:submit.prevent="pindahSaldo">
                <div>
                    <label class="label">Pilih Alokasi Tujuan</label>
                    <select 
                        wire:model="alokasi_id" 
                        class="w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all mt-1"
                    >
                        <option value="" selected>
                            Pilih Alokasi
                        </option>
                        @foreach ($daftarAlokasi as $alokasi)
                            <option value="{{ $alokasi->id }}">
                                {{ $alokasi->nama }}
                            </option>
                        @endforeach
                    </select>

                    @error('alokasi_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label class="label">Jumlah Saldo</label>
                    <div class="relative flex items-center mt-2 w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus-within:border-[#10B981] transition-all">
                        <span class="text-gray-500 absolute left-3">Rp.</span>
                        <input type="number" wire:model="jumlah" class="w-full pl-10 outline-none"/>
                    </div>
                    @error('jumlah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="modal-action">
                    <button class="btn" onclick="document.getElementById('pindahkanSaldo').close()">Close</button>
                    <button 
                            type="submit" 
                            class="btn btn-success text-white"
                            wire:loading.attr="disabled"
                            wire:target="pindahSaldo"
                            onclick="document.getElementById('pindahkanSaldo').close();"
                        >
                            <span wire:loading.remove wire:target="pindahSaldo">Pindahkan Saldo</span>
                            <span wire:loading wire:target="pindahSaldo"><span class="loading loading-spinner loading-md"></span></span>
                    </button>   
                </div>
            </form>
        </div>
    </dialog>

</div>
