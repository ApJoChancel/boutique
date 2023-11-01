<?php

namespace App\Livewire;

use App\Models\Boutique as ModelsBoutique;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Boutique extends AppComponent
{
    use WithPagination;

    const DEFAULT_OBJECTIF = 2000000;

    private static array $headers = [
        'Boutique',
        'Zone',
        'Manager',
    ];
    
    #[Rule('required|min:5|unique:boutiques')]
    public $designation = null;
    #[Rule('sometimes')]
    public $zone_id = null;
    #[Rule('sometimes')]
    public $user_id = null;

    public $objectif = null;

    public $change_zone;
    public $change_objectif;

    public function mount()
    {
        $this->is_com_or_supper = in_array(Auth::user()->type_id, [3, 4]) ? true : false;
        abort_if($this->is_com_or_supper, 403, 'Autorisation refusée');
        
        $this->objectif = self::DEFAULT_OBJECTIF;
        $this->change_zone = false;
        $this->change_objectif = false;
    }

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsBoutique() : ModelsBoutique::findOrFail($this->edit_id);
        $item->designation = $this->designation;
        $item->objectif = $this->objectif;
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
        $this->notificationToast(self::TEXT_SAVED);
    }

    public function editItem(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->designation = $item->designation;
        $this->objectif = $item->objectif;
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
        $this->notificationToast(self::TEXT_DELETE);
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->designation =
            $this->objectif =
            $this->zone_id =
            $this->user_id = null;
            $this->change_zone = false;
            $this->change_objectif = false;
        $this->dispatch('close-modal'); 
    }

    public function changeObjectif(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->change_objectif = true;
        $this->designation = $item->objectif;
        $this->objectif = $item->objectif;
        $this->change_modal = true;
    }

    public function changeObjectifData()
    {
        $this->validate();
        $item = ModelsBoutique::findOrFail($this->edit_id);
        $item->objectif = $this->objectif;
        $item->save();
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    public function changeManager(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->designation = $item->manager ? "{$item->manager->nom} {$item->manager->prenom}" : 'Aucun';
        $this->user_id = $item->manager?->id;
        $this->change_modal = true;
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
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    public function changeZone(ModelsBoutique $item)
    {
        $this->edit_id = $item->id;
        $this->change_zone = true;
        $this->designation = $item->zone->libelle;
        $this->zone_id = $item->zone->id;
        $this->change_modal = true;
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
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Boutique')]
    public function render()
    {
        return view('livewire.boutique', [
            'users' => User::where('role_id', 1)->get(), //Manager
            'zones' => Zone::all(),
            'boutiques' => ModelsBoutique::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
