<?php

namespace App\Livewire;

use App\Models\Objectif as ModelsObjectif;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Objectif extends AppComponent
{
    #[Rule('required|integer|min:1')]
    public $montant = null;

    public function save()
    {
        $this->validate();
        $item = ModelsObjectif::findOrFail(1);
        $item->montant = $this->montant;
        $item->save();
        session()->flash('status', 'Added successfully');
    }

    public function mount()
    {
        $this->montant = ModelsObjectif::findOrFail(1)->montant;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Objectif')]
    public function render()
    {
        return view('livewire.objectif');
    }
}
