<?php

namespace App\Livewire;

use App\Models\Categorie as ModelsCategorie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Categorie extends AppComponent
{
    #[Rule('required|min:2|unique:categories')]
    public $libelle = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsCategorie() : ModelsCategorie::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
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
        parent::deleteItem(ModelsCategorie::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsCategorie::findOrFail($id));
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Categorie')]
    public function render()
    {
        return view('livewire.categorie', [
            'categories' => ModelsCategorie::all(),
        ]);
    }
}
