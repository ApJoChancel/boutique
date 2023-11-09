<?php

namespace App\Livewire;

use App\Models\Caution as ModelsCaution;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Caution extends AppComponent
{
    private static array $headers = [
        'Date de vente',
        'Client',
        'Caution',
        'Date limite',
        'Statut',
    ];

    public $caution;
    public $delais;
    public $etat;
    #[Rule('required|integer')]
    public $penalite_delais;
    #[Rule('required|integer')]
    public $penalite_etat;

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        $this->is_admin_or_suppleant = in_array(Auth::user()->type_id, [1, 2]) ? true : false;
    }

    public function infoItem(ModelsCaution $item)
    {
        $this->caution = $item;
        $this->info_modal = true;
    }

    public function demandeLeverCautionItem(ModelsCaution $item)
    {
        $this->edit_id = $item->id;
        $this->textSubmit = 'Valider';
        $this->info_modal = false;
        $this->paie_modal = true;
    }

    public function demandeLeverCautionItemData(ModelsCaution $item)
    {
        $item->date_retour = $this->delais;
        $item->niveau_degradation = $this->etat;
        $item->save();
        $this->notificationToast("Demande envoyée");
        $this->resetValues();
    }

    public function validationLeverCautionItemData(ModelsCaution $item)
    {
        $this->validate();
        $item->penalite_date = $this->penalite_delais;
        $item->penalite_degradation = $this->penalite_etat;
        $item->est_finalisee = true;
        $item->save();
        $this->notificationToast("Demande validée");
        $this->resetValues();
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->caution = null;
        $this->delais = null;
        $this->etat = null;
        $this->penalite_delais = null;
        $this->penalite_etat = null;
    }
    
    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Caution')]
    public function render()
    {
        return view('livewire.caution',[
            'cautions' => ModelsCaution::all(),
            'headers' => self::$headers,
        ]);
    }
}
