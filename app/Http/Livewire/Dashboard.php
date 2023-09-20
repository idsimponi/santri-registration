<?php

namespace App\Http\Livewire;

use App\Models\Santri;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $dataPribadi;

    public function mount()
    {
        $this->dataPribadi = Santri::where('username', Auth::user()->username)->first();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

}
