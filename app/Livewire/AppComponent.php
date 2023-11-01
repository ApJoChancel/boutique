<?php

namespace App\Livewire;

use App\Models\Boutique;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppComponent extends Component
{
    const TEXT_SUBMIT = 'Enregistrer';
    const TEXT_DELETE = 'Suppression réussie';
    const TEXT_SAVED = 'Enregistrement réussi';
    const TEXT_MODIFY = 'Modification réussie';
    public $edit_id = null;
    public $delete_id = null;
    public $textSubmit = self::TEXT_SUBMIT;

    public $confirm_modal = false;
    public $change_modal = false;
    public $info_modal = false;
    public $paie_modal = false;

    //Pour les rôles
    public $boutiques_valides;
    public $is_admin;
    public $is_com;
    public $is_admin_or_suppleant;

    public function boutiqueValide()
    {
        switch (Auth::user()->type_id) {
            case 1:
            case 2:
                return Boutique::all()->pluck('id')->toArray();
                break;
            case 3:
                return Auth::user()->zone->boutiques->pluck('id')->toArray();
                break;
            case 4:
                return [Auth::user()->boutique_id];
                break;
        }
    }

    public function deleteItem(mixed $item)
    {
        $this->delete_id = $item->id;
        $this->confirm_modal = true;

    }

    public function deleteCancelled()
    {
        $this->resetValues();
        $this->confirm_modal = false;
    }

    public function deleteConfirmed(mixed $item)
    {
        $item->delete();
        $this->resetValues();
        $this->confirm_modal = false;
        $this->dispatch('close-toast-after-3-seconds');
    }

    public function closeToast()
    {
        $this->dispatch('close-toast'); 
    }

    public function resetValues()
    {
        $this->edit_id =
            $this->delete_id = null;
        $this->textSubmit = self::TEXT_SUBMIT;

        $this->confirm_modal =
            $this->change_modal =
            $this->paie_modal =
            $this->info_modal = false;
        $this->resetValidation();
    }

    public function notificationToast(string $message)
    {
        session()->flash('status', $message);
        $this->dispatch('close-toast-after-3-seconds');
    }

    public function count_recursive($array, $limit) {
        $count = 0;
        foreach ($array as $id => $_array) {
            if (is_array ($_array) && $limit > 0) {
                $count += self::count_recursive($_array, $limit - 1);
            } else {
                $count += 1;
            }
        }
        return $count;
    }
}
