<?php

namespace App\Livewire\App\Grafik;

use Livewire\Component;
use App\Models\Alokasi; // Import Model Alokasi
use Illuminate\Support\Facades\Auth;

class GrafikAlokasi extends Component
{
    
    public $user_id;

    public function mount() {
        $this->user_id = Auth::user()->id;
    }

    public function render()
    {
        $alokasi = Alokasi::where('user_id', $this->user_id)->get();

        return view('livewire.app.grafik.grafik-alokasi', [
            'alokasi' => $alokasi,
        ]);
    }
}
