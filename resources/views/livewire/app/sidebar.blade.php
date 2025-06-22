<div class="fixed bottom-0 inset-x-0 z-50 mb-3">
    <div class="max-w-sm mx-auto px-5">
        <div class="bg-white flex justify-evenly items-center py-4 px-4 rounded-2xl shadow-md border border-gray-200 gap-5">

            <a href="/dasbor" class="{{ request()->is('dasbor') ? 'text-[#10B981] border-b-2 border-[#10B981]' : 'text-gray-600' }} pb-1">
                <i class="fa-solid fa-house text-xl"></i>
            </a>

            <a href="/alokasi" class="{{ request()->is('alokasi') ? 'text-[#10B981] border-b-2 border-[#10B981]' : 'text-gray-600' }} pb-1">
                <i class="fa-solid fa-wallet text-xl"></i>
            </a>

            <a href="/alokasi" class="{{ request()->is('alokasi') ? 'text-[#10B981] border-b-2 border-[#10B981]' : 'text-gray-600' }} pb-1">
                <i class="fa-solid fa-plus text-xl"></i>
            </a>

            <a href="/transaksi" class="{{ request()->is('transaksi') ? 'text-[#10B981] border-b-2 border-[#10B981]' : 'text-gray-600' }} pb-1">
                <i class="fa-solid fa-right-left text-xl"></i>
            </a>

            <a href="/akun" class="{{ request()->is('akun') ? 'text-[#10B981] border-b-2 border-[#10B981]' : 'text-gray-600' }} pb-1">
                <i class="fa-solid fa-user text-xl"></i>
            </a>
        </div>
    </div>
</div>
