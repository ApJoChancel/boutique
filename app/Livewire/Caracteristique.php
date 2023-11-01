<?php

namespace App\Livewire;

use App\Models\Caracteristique as ModelsCaracteristique;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Caracteristique extends AppComponent
{
    use WithPagination;

    private static array $headers = [
        'Caractéristique',
        'type',
    ];
    
    #[Rule('required|min:2|unique:caracteristiques')]
    public $libelle;
    #[Rule('sometimes')]
    public $options;
    #[Rule('required')]
    public $type;

    public function save()
    {
        $this->validate();
        $item = new ModelsCaracteristique();
        $item->libelle = $this->libelle;
        $item->type = $this->type;
        DB::beginTransaction();
            $item->save();
            if($this->options){
                $tab = nl2br($this->options);
                foreach(explode('<br />', $tab) as $option){
                    $option = trim($option);
                    $opt = Option::where('libelle', $option)->first();
                    if(!$opt){
                        $opt = new Option();
                        $opt->libelle = $option;
                        $opt->caracteristique_id = $item->id;
                        $opt->save();
                    }
                }
            }
        DB::commit();
        $this->resetValues();
        $this->notificationToast(self::TEXT_SAVED);
    }

    public function editItem(ModelsCaracteristique $item)
    {
        $this->resetValidation();
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        $item = ModelsCaracteristique::findOrFail($id);
        if($item->options->get(0)){
            $this->addError('libelle', 'Pour supprimer cette caractéristiques, retirez-lui les options associées');
            return;
        }
        parent::deleteItem($item);
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsCaracteristique::findOrFail($id));
        $this->notificationToast(self::TEXT_DELETE);
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->type =
            $this->options = null;
    }

    public function changeOptions(ModelsCaracteristique $item)
    {
        $this->resetValidation();
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $options = '';
        foreach ($item->options as $option) {
            $options .= $option->libelle ."\n";
        }
        $this->options = $options;
        $this->change_modal = true;
    }

    public function changeOptionData()
    {
        $item = ModelsCaracteristique::findOrFail($this->edit_id);
        DB::beginTransaction();
            $item->options()->delete();
            $item->options()->saveMany($this->tabOptionsToIds($this->options, $item));
        DB::commit();
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    private function tabOptionsToIds(string $tab, ModelsCaracteristique $item)
    {
        $options = [];
        $tab = nl2br($tab);
        foreach(explode('<br />', $tab) as $option){
            $option = trim($option);
            $opt = Option::where('libelle', $option)->first();
            if(!$opt){
                $opt = new Option();
                $opt->libelle = $option;
                $opt->caracteristique_id = $item->id;
                $opt->save();
            }
            $options[] = $opt;
        }
        return $options;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Caracteristiques')]
    public function render()
    {
        return view('livewire.caracteristique', [
            'caracteristiques' => ModelsCaracteristique::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
