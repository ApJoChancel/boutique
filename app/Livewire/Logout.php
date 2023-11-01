<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

class Logout extends AppComponent
{
    public function mount()
    {
        Auth::logout();
        return to_route('login');
    }
}
