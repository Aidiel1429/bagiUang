<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Masuk extends Component
{
    public $email, $password;
    public $error;

    public function render()
    {
        return view('livewire.auth.masuk');
    }

    public function masuk() {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        try {
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ])) {
                session()->regenerate();
                return redirect()->intended('/dasbor');
            }

            $this->addError('email', 'Email atau password salah.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    }
}
