<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Keluar extends Component
{
    public function render()
    {
        return view('livewire.auth.keluar');
    }

    public function keluar()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
