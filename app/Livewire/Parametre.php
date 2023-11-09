<?php

namespace App\Livewire;

use App\Models\Parametre as ModelsParametre;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Parametre extends AppComponent
{
    #[Rule('required|integer|min:1')]
    public $delais_vente;
    #[Rule('required|integer|min:1')]
    public $delais_location;
    #[Rule('required|integer|min:1')]
    public $delais_article;

    public $heure;
    public $delais_retard;

    public function mount()
    {
        $this->is_com_or_supper = in_array(Auth::user()->type_id, [3, 4]) ? true : false;
        abort_if($this->is_com_or_supper, 403, 'Autorisation refusée');
        
        $item = ModelsParametre::findOrFail(1);
        $this->delais_vente = $item->delais_vente;
        $this->delais_location = $item->delais_location;
        $this->delais_article = $item->delais_article;
        $this->heure = date('H:i:s', strtotime($item->heure));
        $this->delais_retard = date('H:i:s', strtotime($item->delais_retard));
        $this->textSubmit = 'Modifier';
    }

    public function save()
    {
        $this->validate();
        $item = ModelsParametre::findOrFail(1);
        $item->delais_vente = $this->delais_vente;
        $item->delais_location = $this->delais_location;
        $item->delais_article = $this->delais_article;
        $item->heure = $this->heure;
        $item->delais_retard = $this->delais_retard;
        $item->save();
        session()->flash('status', 'Modification réussie');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Paramètre')]
    public function render()
    {
        return view('livewire.parametre');
    }
}
