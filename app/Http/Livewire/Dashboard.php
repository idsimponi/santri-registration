<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $santriName;

    public function mount()
    {
        $this->santriName = Auth::user()->nama_santri;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

}
