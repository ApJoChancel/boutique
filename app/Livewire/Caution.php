<?php

namespace App\Livewire;

use App\Models\Caution as ModelsCaution;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Caution extends AppComponent
{
    private static array $headers = [
        'Client',
        'Date de vente',
        'Boutique',
        'Caution',
        'Date limite',
        'Statut',
    ];

    public $caution;
    public $delais;
    public $etat;
    public $penalite_delais;
    public $penalite_etat;

    public $clients;

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        $this->is_admin_or_suppleant = in_array(Auth::user()->type_id, [1, 2]) ? true : false;

        //Boutiques valides
        $this->boutiques_valides = $this->boutiqueValide();
    }

    public function infoItem(ModelsCaution $item)
    {
        $this->caution = $item;
        $this->info_modal = true;
    }

    public function demandeLeverCautionItem(ModelsCaution $item)
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');

        $this->edit_id = $item->id;
        $this->textSubmit = 'Valider';
        $this->info_modal = false;
        $this->paie_modal = true;
    }

    public function demandeLeverCautionItemData(ModelsCaution $item)
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if(!$this->is_com, 403, 'Autorisation refusée');

        $item->date_retour = $this->delais;
        $item->niveau_degradation = $this->etat;
        $item->save();
        $this->notificationToast("Demande envoyée");
        $this->resetValues();
    }

    public function validationLeverCautionItemData(ModelsCaution $item)
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');

        if(!empty($this->penalite_delais)){
            $this->penalite_delais = (int) $this->penalite_delais;
            if($this->penalite_delais < 1){
                $this->addError('penalite_delais', 'Doit être un nombre non nul');
                return;
            }
        }
        if(!empty($this->penalite_etat)){
            $this->penalite_etat = (int) $this->penalite_etat;
            if($this->penalite_etat < 1){
                $this->addError('penalite_etat', 'Doit être un nombre non nul');
                return;
            }
        }
        $item->penalite_date = $this->penalite_delais ?? 0;
        $item->penalite_degradation = $this->penalite_etat ?? 0;
        $item->est_finalisee = true;
        $item->save();
        $this->notificationToast("Demande validée");
        $this->resetValues();
    }

    public function confirmRembour(ModelsCaution $item)
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if(!$this->is_com, 403, 'Autorisation refusée');

        $item->est_remboursee = true;
        $item->date_remboursee = now();
        $item->save();
        $this->notificationToast("Confirmation validée");
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
        $this->clients = Client::all();

        return view('livewire.caution',[
            // 'cautions' => ModelsCaution::all(),
            'headers' => self::$headers,
        ]);
    }
}
