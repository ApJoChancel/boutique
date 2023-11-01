<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Compte extends AppComponent
{
    #[Rule('required')]
    public $ancien;
    public $nouveau;
    #[Rule('required|same:nouveau')]
    public $confirm;
    public $voir_mdp;

    // public function changeNoms()
    // {
    //     $item = Auth::user();
    //     dd($item);
    //     $item->noms = $this->noms;
    //     // $item->save();
    //     session()->flash('status', 'Added successfully');
    // }

    public function changePassword()
    {
        $this->validate();
        if(!password_verify($this->ancien, Auth::user()->password)){
            $this->addError('ancien', 'Incorrecte');
        }
        else{
            $item = User::findOrFail(Auth::user()->id);
            $item->password = Hash::make($this->nouveau);
            $item->save();
            $this->resetValues();
            session()->flash('status', 'Added successfully');
        }
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->ancien = null;
        $this->nouveau = null;
        $this->confirm = null;
        $this->voir_mdp = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Compte')]
    public function render()
    {
        return view('livewire.compte');
    }
}
