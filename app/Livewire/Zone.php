<?php

namespace App\Livewire;

use App\Models\Zone as ModelsZone;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Zone extends AppComponent
{
    #[Rule('required|unique:zones')]
    public $libelle = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsZone() : ModelsZone::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Added successfully');
    }

    public function editItem(ModelsZone $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsZone::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsZone::findOrFail($id));
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Zone')]
    public function render()
    {
        return view('livewire.zone', [
            'zones' => ModelsZone::all(),
        ]);
    }
}
