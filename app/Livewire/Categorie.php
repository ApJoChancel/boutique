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

    public $option_modal;
    public $change_carac;
    public $optionOf;
    public $options;

    public function save()
    {
        if(!$this->change_carac)
            $this->validate();
        $item = (!$this->edit_id) ? new ModelsCategorie() : ModelsCategorie::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        if($this->carac)
            $item->options()->sync($this->carac);
        $this->resetValues();
        $this->notificationToast('Saved successfully');
    }

    public function fermer()
    {
        $this->option_modal = false;
    }

    public function changeOption(Caracteristique $item)
    {
        $this->optionOf = $item;
        $this->option_modal = true;
    }

    public function editItem(ModelsCategorie $item)
    {
        $this->change_carac = false;
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        if($item->options->get(0)){
            $this->notificationToast('Pour supprimer cette catégorie, retirez-lui les caractéristiques associées');
            $this->resetValues();
            return;
        }elseif ($item->articles->get(0)) {
            $this->notificationToast('Pour supprimer cette catégorie, retirez-lui les articles associés');
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
        $this->option_modal = false;
        $this->change_carac = false;
        $this->optionOf = null;
        $this->options = null;
    }

    public function changeCarac(ModelsCategorie $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->carac = $item->options()->pluck('options.id');
        $this->change_carac = true;
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
