<?php

namespace App\Livewire;

use App\Models\Paiement;
use App\Models\Vente;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Recouvrement extends AppComponent
{
    public $ventes = null;
    public $vente = null;
    
    #[Rule('required|integer')]
    public $montant = null;
    #[Rule('required|integer')]
    public $reduction = null;

    public $info_modal = false;


    public function infoItem(Vente $item)
    {
        $this->vente = $item;
        $this->info_modal = true;
    }

    public function paiementItem(Vente $item)
    {
        $this->edit_id = $item->id;
        $this->textSubmit = 'Valider le paiement';
        $this->info_modal = false;
        $this->paie_modal = true;
    }

    public function paiementItemData(Vente $item)
    {
        $result = DB::table('ventes')->select(
            DB::raw('(ventes.montant - SUM(paiements.montant + paiements.reduction)) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->where('ventes.id', $item->id)
        ->groupBy('ventes.id', 'ventes.montant')
        ->first();
        if(($this->montant + $this->reduction) <= $result->reste){
            $paie = new Paiement();
            $paie->montant = $this->montant;
            $paie->reduction = $this->reduction ?? 0;
            $paie->date = now();
            $paie->vente_id = $item->id;
            $paie->save();
            $this->notificationToast('Saved successfully');
            $this->resetValues();
        } else{
            $this->notificationToast("Attention le reste à payer est de {$result->reste}");
        }
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->montant =
            $this->reduction = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | recouvrement')]
    public function render()
    {
        $this->ventes = DB::table('ventes')->select(
            'ventes.id AS vente_id',
            'clients.nom AS nom',
            'clients.prenom AS prenom',
            'ventes.date AS date_vente',
            'ventes.montant AS montant_vente',
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('(ventes.montant - SUM(paiements.montant + paiements.reduction)) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->leftJoin('clients', 'clients.id', 'ventes.client_id')
        ->groupBy('ventes.id', 'clients.nom', 'clients.prenom', 'ventes.date', 'ventes.montant')
        ->having('reste', '>', 0)
        ->get();
        
        return view('livewire.recouvrement',[
            'vente' => $this->vente,
        ]);
    }
}
