<?php

namespace App\Livewire;

use App\Models\Article as ModelsArticle;
use App\Models\Categorie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Article extends AppComponent
{
    #[Rule('required|unique:articles')]
    public $libelle = null;
    #[Rule('sometimes')]
    public $categorie_id = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsArticle() : ModelsArticle::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        if($this->categorie_id)
            $item->categorie_id = $this->categorie_id;
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Saved successfully');
    }

    public function editItem(ModelsArticle $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->categorie_id = null;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsArticle::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsArticle::findOrFail($id));
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->categorie_id = null;
        $this->dispatch('close-modal'); 
    }

    public function changeCategorie(ModelsArticle $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->categorie->libelle;
        $this->categorie_id = $item->categorie->id;
        $this->dispatch('show-change');
    }

    public function changeCategorieData()
    {
        $this->validate();
        $item = ModelsArticle::findOrFail($this->edit_id);
        $categorie = Categorie::findOrFail($this->categorie_id);
        $item->categorie()->associate($categorie);
        $item->save();
        $this->dispatch('close-modal'); 
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Article')]
    public function render()
    {
        return view('livewire.article', [
            'categories' => Categorie::all(),
            'articles' => ModelsArticle::all(),
        ]);
    }
}
