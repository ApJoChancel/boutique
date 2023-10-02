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
    ];
    
    #[Rule('required|min:2|unique:caracteristiques')]
    public $libelle = null;
    #[Rule('sometimes')]
    public $options = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsCaracteristique() : ModelsCaracteristique::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        DB::beginTransaction();
            $item->save();
            if($this->options)
                $item->options()->sync($this->tableOptionsToIds($this->options));
        DB::commit();
        $this->resetValues();
        $this->notificationToast('Saved successfully');
    }

    public function editItem(ModelsCaracteristique $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsCaracteristique::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsCaracteristique::findOrFail($id));
        $this->notificationToast('Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->options = null;
    }

    public function changeOptions(ModelsCaracteristique $item)
    {
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
            $item->options()->sync($this->tableOptionsToIds($this->options));
        DB::commit();
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast('Changed successfully');
    }

    private function tableOptionsToIds(string $table)
    {
        $options = [];
        $table = nl2br($table);
        foreach(explode('<br />', $table) as $option){
            $option = trim($option);
            $opt = Option::where('libelle', $option)->first();
            if(!$opt){
                $opt = new Option();
                $opt->libelle = $option;
                $opt->save();
            }
            $options[] = $opt->id;
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
