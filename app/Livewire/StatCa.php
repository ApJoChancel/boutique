<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use stdClass;

class StatCa extends AppComponent
{
    public $date_from;
    public $date_to;

    public function mount()
    {
        //Boutiques valides
        $this->boutiques_valides = $this->boutiqueValide();
        //Les dates
        $paiements = DB::table('paiements')
        ->select(
            DB::raw('MIN(paiements.date) AS date_from'),
            DB::raw('MAX(paiements.date) AS date_to'),
        )
        ->join('ventes', 'ventes.id', 'paiements.vente_id')
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->first();

        $this->date_from = $paiements->date_from;
        $this->date_to = $paiements->date_to;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | CA')]
    public function render()
    {
        $ventes = DB::table('ventes')
        ->select(
            DB::raw('ventes.montant AS montant_total'),
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('ventes.montant - SUM(paiements.montant + paiements.reduction) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->whereBetween('paiements.date', [$this->date_from, $this->date_to])
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->groupBy('ventes.id', 'paiements.date', 'ventes.montant')
        ->get();
        
        $totaux = new stdClass();
        $totaux->montant_total = $ventes->sum('montant_total');
        $totaux->reduction = $ventes->sum('reduction');
        $totaux->montant_recu = $ventes->sum('montant_recu');
        $totaux->reste = $ventes->sum('reste');

        return view('livewire.stat-ca',[
            'labels' => [
                "CA", 
                'Réduction', 
                'Reçu', 
                'Reste'
            ],
            'totaux' => [
                $totaux->montant_total,
                $totaux->reduction,
                $totaux->montant_recu,
                $totaux->reste
            ],
        ]);
    }
}
