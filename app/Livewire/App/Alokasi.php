<?php

namespace App\Livewire\App;

use App\Models\Alokasi as ModelsAlokasi;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Alokasi - BagiUang')]

class Alokasi extends Component
{
    public $user_id, $nama, $persentase, $icon, $totalPersentase; 

    public function mount() {
        $this->user_id = Auth::user()->id;

        $this->totalPersentase = ModelsAlokasi::where('user_id', $this->user_id)->sum('persentase');
    }

    public function getIconFor($name)
    {
        // Daftar kata kunci per kategori
        $categories = [
            'fa-utensils' => ['makan', 'jajan', 'sarapan', 'dinner', 'lunch'], 
            'fa-bus' => ['transport', 'bis', 'bus', 'travel'], 
            'fa-piggy-bank' => ['tabung', 'simpan'], 
            'fa-film' => ['hiburan', 'nonton', 'film'], 
            'fa-shopping-bag' => ['belanja', 'shopping', 'beli'], 
            'fa-chart-line' => ['investasi', 'saham', 'reksadana'], 
            'fa-heart-pulse' => ['kesehatan', 'dokter', 'obat'], 
            'fa-triangle-exclamation' => ['darurat', 'emergency', 'urgent'], 
        ];

        $name = strtolower($name);

        foreach ($categories as $icon => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $icon;
                }
            }
        }

        // Jika tidak cocok dengan kategori apa pun
        return 'fa-wallet';
    }


    public function store() {
        $this->validate([
            'nama' => 'required|string|max:255',
            'persentase' => 'required|numeric|min:0|max:100',
        ], [
            'nama.required' => 'Nama alokasi harus diisi.',
            'persentase.required' => 'Persentase harus diisi.',
            'persentase.numeric' => 'Persentase harus berupa angka.',
            'persentase.min' => 'Persentase tidak boleh kurang dari 0.',
            'persentase.max' => 'Persentase tidak boleh lebih dari 100.',
        ]);

        try {
            $this->icon = $this->getIconFor($this->nama);

            if (ModelsAlokasi::where('user_id', $this->user_id)->where('nama', $this->nama)->exists()) {
                session()->flash('error', 'Alokasi dengan nama tersebut sudah ada.');
                return redirect(request()->header('Referer'));
            }

            if ($this->totalPersentase >= 100) {
                session()->flash('error', 'Alokasi sudah mencapai batas maksimal.');
                return redirect(request()->header('Referer'));
            }

            if (($this->totalPersentase + $this->persentase) > 100) {
                session()->flash('error', 'Total persentase alokasi tidak boleh melebihi 100%.');
                return redirect(request()->header('Referer'));
            }
            
            $data = ModelsAlokasi::create([
                'user_id' => $this->user_id,
                'nama' => $this->nama,
                'persentase' => $this->persentase,
                'icon' => $this->icon,
            ]);

            if ($data) {
                session()->flash('success', 'Alokasi berhasil dibuat.');
                $this->reset_form();
                return redirect(request()->header('Referer'));
            } else {
                session()->flash('error', 'Gagal membuat alokasi.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat membuat alokasi');
        }
    }

    public function render()
    {
        $alokasis = ModelsAlokasi::where('user_id', $this->user_id)->get();
        return view('livewire.app.alokasi', [
            'alokasis' => $alokasis,
        ]);
    }

    public function reset_form() {
        $this->nama = '';
        $this->persentase = '';
        $this->icon = '';
    }
}
