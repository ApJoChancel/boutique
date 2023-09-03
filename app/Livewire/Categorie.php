<?php

namespace App\Livewire;

use App\Models\Caracteristique;
use App\Models\Categorie as ModelsCategorie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Categorie extends AppComponent
{
    #[Rule('required|unique:categories')]
    public $libelle = null;
    #[Rule('sometimes')]
    public $carac = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsCategorie() : ModelsCategorie::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        if($this->carac)
            $item->caracteristiques()->sync($this->carac);
        $this->resetValues();
        session()->flash('status', 'Saved successfully');
    }

    public function editItem(ModelsCategorie $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        if($item->caracteristiques->get(0)){
            session()->flash('status', 'You cannnot deleted this item');
            $this->resetValues();
            return;
        }
        parent::deleteItem($item);
    }

    public function deleteConfirmed(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        parent::deleteConfirmed($item);
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->carac = null;
        $this->dispatch('close-modal');
    }

    public function changeCarac(ModelsCategorie $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->carac = $item->caracteristiques()->pluck('caracteristiques.id');
        $this->dispatch('show-change');
    }

    public function changeCaracData()
    {
        $item = ModelsCategorie::findOrFail($this->edit_id);
        $item->caracteristiques()->sync($this->carac);
        $this->dispatch('close-modal'); 
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Categorie')]
    public function render()
    {
        return view('livewire.categorie', [
            'caracs' => Caracteristique::all(),
            'categories' => ModelsCategorie::all(),
        ]);
    }
}
