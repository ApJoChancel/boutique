<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Paiement;
use App\Models\Vente;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Recouvrement extends AppComponent
{
    private static array $headers = [
        'Client',
        'Date de vente',
        'Boutique',
        'Montant vente',
        'Réduction accordée',
        'Montant reçu',
        'Reste à percevoir',
        'Téléphone',
    ];

    public $clients = null;

    public $ventes = null;
    public $vente = null;

    public $date_from = null;
    public $date_to = null;
    
    #[Rule('required|integer')]
    public $montant = null;
    #[Rule('required|integer')]
    public $reduction = null;

    public $info_modal = false;

    public function mount()
    {
        //Boutiques valides
        $this->boutiques_valides = $this->boutiqueValide();

        $ventes = DB::table('ventes')
        ->select(
            DB::raw('MIN(ventes.date) AS date_from'),
            DB::raw('MAX(ventes.date) AS date_to'),
        )
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->first();

        $this->date_from = $ventes->date_from;
        $this->date_to = $ventes->date_to;
    }

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
            $this->notificationToast(self::TEXT_SAVED);
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
            'clients.telephone AS telephone',
            'ventes.date AS date_vente',
            'ventes.montant AS montant_vente',
            'boutiques.designation AS boutique',
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('(ventes.montant - SUM(paiements.montant + paiements.reduction)) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->leftJoin('clients', 'clients.id', 'ventes.client_id')
        ->leftJoin('boutiques', 'boutiques.id', 'ventes.boutique_id')
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->groupBy('ventes.id',
            'clients.nom',
            'clients.prenom',
            'clients.telephone',
            'ventes.date',
            'ventes.montant',
            'boutiques.designation'
        )
        ->having('reste', '>', 0)
        ->get();
        $total = $this->ventes->sum('reste');

        $this->clients = Client::all();
        
        return view('livewire.recouvrement',[
            'vente' => $this->vente,
            'total' => $total,
            'headers' => self::$headers,
        ]);
    }
}
