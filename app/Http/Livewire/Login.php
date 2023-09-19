<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username;
    public $password;

    public function authenticate()
    {
        $credentials = ['username' => $this->username, 'password' => $this->password];

        if (Auth::attempt($credentials)) {
            session()->flash('message', true);
            return redirect()->route('dashboard');
        }

        session()->flash('error', 'Invalid credentials.');
    }
    public function render()
    {
        return view('livewire.login');
    }
    protected $rules = [
        'username' => 'required|email',
        'password' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
