<?php

namespace App\Livewire;

use App\Models\Boutique as ModelsBoutique;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Boutique extends AppComponent
{
    #[Rule('required|min:5|unique:boutiques')]
    public $designation = null;
    #[Rule('sometimes')]
    public $zone_id = null;
    #[Rule('sometimes')]
    public $user_id = null;

    public $change_zone = false;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsBoutique() : ModelsBoutique::findOrFail($this->edit_id);
        $item->designation = $this->designation;
        $item->zone_id = $this->zone_id;
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
        $this->zone_id = $item->zone->id;
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
            $this->zone_id =
            $this->user_id = null;
            $this->change_zone = false;
        $this->dispatch('close-modal'); 
    }

    public function changeManager(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->designation = "{$item->manager->nom} {$item->manager->prenom}";
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

    public function changeZone(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->change_zone = true;
        $this->designation = $item->zone->libelle;
        $this->zone_id = $item->zone->id;
        $this->dispatch('show-change');
    }

    public function changeZoneData()
    {
        $this->validate();
        $item = ModelsBoutique::findOrFail($this->edit_id);
        $zone = Zone::find($this->zone_id);
        DB::beginTransaction();
            $item->zone()->associate($zone);
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
            'users' => User::where('role_id', 1)->get(), //Manager
            'zones' => Zone::all(),
            'boutiques' => ModelsBoutique::all(),
        ]);
    }
}
