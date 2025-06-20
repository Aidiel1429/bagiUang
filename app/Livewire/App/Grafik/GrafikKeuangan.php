<?php

namespace App\Livewire\App\Grafik;

use Livewire\Component;

class GrafikKeuangan extends Component
{
    public $labels = [];
    public $pemasukan = [];
    public $pengeluaran = [];

    public function mount()
    {
        // Data dummy
        $this->labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
        $this->pemasukan = [2000000, 2500000, 2200000, 2700000, 3000000];
        $this->pengeluaran = [1500000, 1800000, 1700000, 1600000, 2000000];
    }

    public function render()
    {
        return view('livewire.app.grafik.grafik-keuangan');
    }
}
