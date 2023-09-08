<?php

namespace App\Livewire;

use App\Models\Boutique as ModelsBoutique;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Boutique extends AppComponent
{
    #[Rule('required|min:5|unique:boutiques')]
    public $designation = null;
    #[Rule('sometimes')]
    public $user_id = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsBoutique() : ModelsBoutique::findOrFail($this->edit_id);
        $item->designation = $this->designation;
        $user = User::find($this->user_id);
        DB::beginTransaction();
            $item->save();
            if($user){
                $item->manager()->save($user);
                $item->save();
            }
        DB::commit();
        $this->resetValues();
        session()->flash('status', 'Saved successfully');
    }

    public function editItem(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->designation = $item->designation;
        $this->user_id = null;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsBoutique::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsBoutique::findOrFail($id));
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->designation =
            $this->user_id = null;
        $this->dispatch('close-modal'); 
    }

    public function changeManager(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->designation = $item->manager->login ?? 'Aucun';
        $this->user_id = $item->manager?->id;
        $this->dispatch('show-change');
    }

    public function changeManagerData()
    {
        $this->validate();
        $item = ModelsBoutique::findOrFail($this->edit_id);
        $user = User::find($this->user_id);
        DB::beginTransaction();
            $item->manager()->save($user);
            $item->save();
        DB::commit();
        $this->dispatch('close-modal'); 
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Boutique')]
    public function render()
    {
        return view('livewire.boutique', [
            'users' => User::where('role_id', 1)->get(),
            'boutiques' => ModelsBoutique::all(),
        ]);
    }
}
