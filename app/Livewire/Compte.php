<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Compte extends AppComponent
{
    #[Rule('required')]
    public $noms = null;
    #[Rule('required')]
    // public $ancien = '';
    // #[Rule('required|same:confirm')]
    // public $nouveau = '';
    // public $confirm = '';

    public function changeNoms()
    {
        $item = Auth::user();
        dd($item);
        $item->noms = $this->noms;
        // $item->save();
        session()->flash('status', 'Added successfully');
    }

    public function pass()
    {
        $this->validate();
        if(Hash::make($this->nouveau) !== Auth::user()->password){
            session()->flash('status', 'Added failed');
        }
        else{
            Auth::user()->password = Hash::make($this->nouveau);
            // Auth::user()->save();
            session()->flash('status', 'Added successfully');
        }
    }

    public function mount()
    {
        $this->noms = Auth::user()->noms;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Compte')]
    public function render()
    {
        return view('livewire.compte');
    }
}
