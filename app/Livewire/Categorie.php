<?php

namespace App\Livewire;

use App\Models\Caracteristique;
use App\Models\Categorie as ModelsCategorie;
use Illuminate\Support\Facades\Auth;
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
    public $libelle;
    public $carac;

    public $option_modal;
    public $change_carac;
    public $optionOf;
    public $options;
    public $selectAll;

    public function mount()
    {
        $this->is_com_or_supper = in_array(Auth::user()->type_id, [3, 4]) ? true : false;
        abort_if($this->is_com_or_supper, 403, 'Autorisation refusée');

        $this->selectAll = false;
        $this->libelle = null;
        foreach (Caracteristique::all() as $item) {
            $this->carac[$item->id] = [];
        }
        // dd($this->carac);

    }

    public function save()
    {
        if(!$this->change_carac)
            $this->validate();
        $item = (!$this->edit_id) ? new ModelsCategorie() : ModelsCategorie::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        if($this->carac)
            $item->options()->sync(array_merge(...$this->carac));
        $this->resetValues();
        $this->notificationToast(self::TEXT_SAVED);
    }

    public function fermer()
    {
        $this->option_modal = false;
    }

    public function changeOption(Caracteristique $item)
    {
        $this->optionOf = $item;
        if($this->edit_id){
            $categorie = ModelsCategorie::findOrFail($this->edit_id);
            if(empty($this->carac[$item->id])){
                foreach ($categorie->options as $option) {
                    if($item->id == $option->caracteristique_id)
                        $this->carac[$item->id][] = $option->id;
                }
            }
            // $this->carac[$item->id] = $this->optionOf->options->pluck('id')->toArray();
            // dd($categorie->options->pluck('id')->toArray(), $this->optionOf->options->pluck('id')->toArray());
            // dd($this->optionOf->options->pluck('id')->toArray());
            // if(!is_array($this->carac[$item->id]))
            //     $this->carac[$item->id] = $this->carac[$item->id]->toArray();
            // $this->carac[$item->id] = array_intersect($this->carac[$item->id], $categorie->options->pluck('id')->toArray());
            // dd($this->carac);
            if(array_diff($this->optionOf->options->pluck('id')->toArray(), $this->carac[$item->id]) === [])
                $this->selectAll = true;
            else
                $this->selectAll = false;
        } else{
            if(empty($this->carac[$item->id])){
                $this->carac[$item->id] = [];
            }
            if(array_diff($this->optionOf->options->pluck('id')->toArray(), $this->carac[$item->id]) === [])
                $this->selectAll = true;
            else
                $this->selectAll = false;
        }
        // dd($this->carac);
        $this->option_modal = true;
    }

    public function selectedAll(int $idCarac)
    {
        $this->carac[$idCarac] = ($this->selectAll) ? $this->optionOf->options->pluck('id')->toArray() : [];
    }

    public function editItem(ModelsCategorie $item)
    {
        $this->resetValidation();
        $this->change_carac = false;
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        if($item->options->get(0)){
            $this->resetValues();
            $this->libelle = $item->libelle;
            $this->addError('libelle', 'Pour supprimer cette catégorie, retirez-lui les caractéristiques associées');
            return;
        }elseif ($item->articles->get(0)) {
            $this->resetValues();
            $this->libelle = $item->libelle;
            $this->addError('libelle', 'Pour supprimer cette catégorie, retirez-lui les articles associés');
            return;
        }
        parent::deleteItem($item);
    }

    public function deleteConfirmed(mixed $id)
    {
        $item = ModelsCategorie::findOrFail($id);
        parent::deleteConfirmed($item);
        $this->notificationToast(self::TEXT_DELETE);
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
        foreach (Caracteristique::all() as $car) {
            $this->carac[$car->id] = [];
        }
        foreach (Caracteristique::all() as $car) {
            self::changeOption($car);
        }
        $this->option_modal = false;
        // $this->carac = $item->options()->pluck('options.id');
        $this->change_carac = true;
    }

    public function changeCaracData()
    {
        $item = ModelsCategorie::findOrFail($this->edit_id);
        $item->caracteristiques()->sync($this->carac);
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
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
