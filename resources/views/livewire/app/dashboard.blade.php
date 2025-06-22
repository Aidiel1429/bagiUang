<div class="bg-[#F3F4F6] h-full min-h-screen max-w-sm container mx-auto pb-20">
    <div>
        <livewire:app.sidebar />
    </div>
    <div class="px-5 py-5">
        <div>
            <h1 class="text-2xl font-bold mt-1">Hai, {{ Auth::user()->name }}</h1>
            <h1 class="text-sm font-medium text-[#3F3F3F]">Selamat Datang !</h1>
        </div>

        <div class="bg-white rounded-2xl p-5 mt-5 text-center">
            <p class="font-medium text-[#3F3F3F] text-sm">Total Saldo</p>
            <h1 class="font-bold text-lg mt-2">Rp. {{ number_format($totalSaldo, 0, ',', '.') }}</h1>
        </div>

        <div class="mt-5">
            <h1 class="text-lg font-bold">Alokasi</h1>
            <div class="mt-3 overflow-x-auto whitespace-nowrap no-scrollbar">
                <div class="inline-flex gap-4 w-full">
                    @forelse ($alokasi as $item)
                        <div class="bg-white p-5 rounded-2xl max-w-[250px] min-w-[250px]">
                            <i class="fa-solid {{ $item->icon }} text-3xl"></i>
                            <p class="text-[#5C5C5C] font-semibold mt-2 text-base">{{ $item->nama }}</p>
                            <p class="font-bold text-xl mt-2">Rp. {{ number_format($item->total_jumlah ?? 0, 0, ',', '.') }}</p>
                            <p class="text-end mt-3 font-semibold text-[#10B981]">{{ $item->persentase }}%</p>
                        </div>
                    @empty
                        <div class="flex justify-center items-center w-full">
                            <p class="text-center">Tidak ada alokasi yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h1 class="text-lg font-bold">Transaksi Terbaru</h1>
            <div class="mt-3">
                @forelse ($riwayat as $item)
                    <div class="bg-white p-5 rounded-2xl flex items-center justify-between mt-3">
                        <div class="flex items-center gap-5">
                            <i class="fa-solid fa-user text-xl"></i>
                            <div>
                                <p class="text-sm font-semibold">{{ $item->nama }}</p>
                                <p class="text-xs">{{ $item->tanggal }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-sm font-semibold">+ Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                            <p class="text-xs items-end">{{ $item->alokasi->nama }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Tidak ada transaksi terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
