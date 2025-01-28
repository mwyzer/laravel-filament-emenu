<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BottomNavigation extends Component
{
    public $username;
    public $currentRoute;

    public function mount($username)
    {
        $this->username = $username;
        $this->currentRoute = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.bottom-navigation');
    }
}
