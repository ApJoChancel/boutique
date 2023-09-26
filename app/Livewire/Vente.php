<?php

namespace App\Livewire;

use App\Models\Vente as ModelsVente;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Vente extends AppComponent
{
    public $ventes = null;
    public $vente = null;
    
    public $info_modal = false;

    public $date_from = null;
    public $date_to = null;

    public function mount()
    {
        $ventes = DB::table('ventes')
        ->select(
            DB::raw('MIN(ventes.date) AS date_from'),
            DB::raw('MAX(ventes.date) AS date_to'),
        )
        ->first();

        $this->date_from = $ventes->date_from;
        $this->date_to = $ventes->date_to;
    }

    public function infoItem(int $id)
    {
        $this->vente = ModelsVente::findOrFail($id);
        $this->info_modal = true;
    }

    public function resetValues()
    {
        parent::resetValues();
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Vente')]
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
        ->whereBetween('paiements.date', [$this->date_from, $this->date_to])
        ->groupBy('ventes.id', 'clients.nom', 'clients.prenom', 'ventes.date', 'ventes.montant')
        ->having('reste', 0)
        ->get();
        $total = $this->ventes->sum('montant_recu');
        $total += $this->ventes->sum('reduction');
        
        return view('livewire.vente',[
            'vente' => $this->vente,
            'total' => $total,
        ]);
    }
}
