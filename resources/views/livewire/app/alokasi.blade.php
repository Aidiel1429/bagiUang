<div class="bg-[#F3F4F6] h-full min-h-screen max-w-sm container mx-auto pb-20">
    <div>
        <livewire:app.sidebar />
    </div>

    <div class="px-5 py-5">       
        <livewire:app.grafik.grafik-alokasi />

        <div class="mt-10">
            @if (session()->has('success'))
                    <div    
                        x-data="{ show: true }" 
                        x-show="show"
                        x-transition 
                        x-init="setTimeout(() => show = false, 3000)"
                        role="alert" 
                        class="alert alert-success mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
            @endif
            @if (session()->has('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        role="alert"
                        class="alert alert-error mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938-7.938a9 9 0 1112.728 12.728A9 9 0 015.07 7.07z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>         
            @endif
            <div class="grid grid-cols-2 gap-4 mt-5">
                @forelse ($alokasis as $alokasi)
                    <div class="bg-white shadow-md rounded-2xl p-4">
                        <i class="fa-solid {{ $alokasi->icon }} text-3xl text-[#10B981]"></i>
                        <h1 class="font-semibold mt-2 truncate">{{ $alokasi->nama }}</h1>
                        <p class="font-medium text-sm text-[#3F3F3F]">{{ $alokasi->persentase }}%</p>
                    </div>
                @empty
                    <div class="col-span-2">
                        <p class="text-center font-semibold">Tidak ada alokasi yang tersedia.</p>
                    </div>
                @endforelse

                @if ($this->totalPersentase < 100)  
                    <div 
                        class="bg-white shadow-md rounded-2xl p-3 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100
                            {{ $alokasis->count() == 0 ? 'col-span-2' : '' }}"
                    onclick="document.getElementById('buatAlokasi').showModal()"
                    >
                        <i class="fa-solid fa-plus text-2xl text-[#10B981]"></i>
                        <p class="text-sm font-semibold mt-2">Buat Alokasi</p>
                    </div>
                @else
                    <div class="col-span-2">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <dialog id="buatAlokasi" class="modal" wire:ignore.self>
        <div class="modal-box">
            <h3 class="text-lg font-bold">Buat Alokasi!</h3>
            <form class="mt-5" wire:submit.prevent="store">
                <div>
                    <input type="hidden" wire:model="user_id" class="px-3 py-2 w-full border border-gray-700 outline-[#10B981] rounded-lg mt-1" />
                </div>
                <div>
                    <label for="namaAlokasi" class="label">Nama Alokasi</label>
                    <input wire:model="nama" type="text" class="px-3 py-2 w-full border border-gray-700 outline-[#10B981] rounded-lg mt-1" />
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="persentaseAlokasi" class="label">Persentase Alokasi</label>
                    <input wire:model="persentase" type="text" class="px-3 py-2 w-full border border-gray-700 outline-[#10B981] rounded-lg mt-1" />
                    @error('persentase') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="modal-action">
                    <button type="button" class="btn" onclick="document.getElementById('buatAlokasi').close()">Close</button>
                    <button 
                        type="submit" 
                        class="btn btn-active btn-success text-white flex items-center justify-center"
                        wire:loading.attr="disabled"
                        onclick="document.getElementById('buatAlokasi').close()"
                    >
                        <span wire:loading class="loading loading-spinner loading-md"></span>
                        <span wire:loading.remove>Buat Alokasi</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</div>
