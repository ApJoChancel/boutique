<?php

namespace App\Livewire;

use App\Models\Caracteristique as ModelsCaracteristique;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Caracteristique extends AppComponent
{
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
        session()->flash('status', 'Saved successfully');
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
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->options = null;
        $this->dispatch('close-modal'); 
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
        $this->dispatch('show-change');
    }

    public function changeOptionData()
    {
        $item = ModelsCaracteristique::findOrFail($this->edit_id);
        DB::beginTransaction();
            $item->options()->sync($this->tableOptionsToIds($this->options));
        DB::commit();
        $this->dispatch('close-modal'); 
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
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
            'caracteristiques' => ModelsCaracteristique::all(),
        ]);
    }
}
