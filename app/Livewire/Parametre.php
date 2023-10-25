<?php

namespace App\Livewire;

use App\Models\Parametre as ModelsParametre;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Parametre extends AppComponent
{
    #[Rule('required|integer|min:1')]
    public $delais_vente;
    #[Rule('required|integer|min:1')]
    public $delais_location;

    public $heure;

    public function mount()
    {
        $item = ModelsParametre::findOrFail(1);
        $this->delais_vente = $item->delais_vente;
        $this->delais_location = $item->delais_location;
        $this->heure = date('H:i:s', strtotime($item->heure));
        $this->textSubmit = 'Modifier';
    }

    public function save()
    {
        $this->validate();
        $item = ModelsParametre::findOrFail(1);
        $item->delais_vente = $this->delais_vente;
        $item->delais_location = $this->delais_location;
        $item->heure = $this->heure;
        $item->save();
        session()->flash('status', 'Change successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Paramètre')]
    public function render()
    {
        return view('livewire.parametre');
    }
}
