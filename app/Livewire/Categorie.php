<?php

namespace App\Livewire;

use App\Models\Caracteristique;
use App\Models\Categorie as ModelsCategorie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Categorie extends AppComponent
{
    use WithPagination;

    private static array $headers = [
        'Catégorie',
    ];
    
    #[Rule('required|unique:categories')]
    public $libelle = null;
    #[Rule('sometimes')]
    public $carac = [];

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsCategorie() : ModelsCategorie::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        if($this->carac)
            $item->caracteristiques()->sync($this->carac);
        $this->resetValues();
        $this->notificationToast('Saved successfully');
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
            $this->notificationToast('Pour supprimer cette catégorie, retirez-lui les caractéristiques associées');
            $this->resetValues();
            return;
        }
        parent::deleteItem($item);
    }

    public function deleteConfirmed(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        parent::deleteConfirmed($item);
        $this->notificationToast('Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle = null;
        $this->carac = [];
    }

    public function changeCarac(ModelsCategorie $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->carac = $item->caracteristiques()->pluck('caracteristiques.id');
        $this->change_modal = true;
    }

    public function changeCaracData()
    {
        $item = ModelsCategorie::findOrFail($this->edit_id);
        $item->caracteristiques()->sync($this->carac);
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast('Changed successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Categorie')]
    public function render()
    {
        return view('livewire.categorie', [
            'caracs' => Caracteristique::all(),
            'categories' => ModelsCategorie::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
