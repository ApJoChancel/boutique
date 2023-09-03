<?php

namespace App\Livewire;

use App\Models\Role as ModelsRole;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Role extends AppComponent
{
    #[Rule('required|unique:roles')]
    public $libelle = null;

    public function addRole()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsRole() : ModelsRole::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Added successfully');
    }

    public function editItem(ModelsRole $role)
    {
        $this->edit_id = $role->id;
        $this->libelle = $role->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsRole::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsRole::findOrFail($id));
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Role')]
    public function render()
    {
        return view('livewire.role', [
            'roles' => ModelsRole::all(),
        ]);
    }
}
