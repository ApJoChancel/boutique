<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class StatCaisse extends AppComponent
{
    public $year;

    public function mount()
    {
        $this->year = Carbon::now()->year;
        //Boutiques valides
        $this->boutiques_valides = $this->boutiqueValide();
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Caisse')]
    public function render()
    {
        $ventes = DB::table('ventes')
        ->select(
            DB::raw('SUM(ventes.montant) AS montant'),
            DB::raw('MONTH(paiements.date) AS mois'),
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('SUM(ventes.montant) - SUM(paiements.montant + paiements.reduction) AS reste')
        )
        ->join('paiements', 'ventes.id', 'paiements.vente_id')
        ->whereYear('paiements.date', $this->year)
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

        $tab = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $moisNom = date('F', mktime(0, 0, 0, $mois, 1));
            $tab[$moisNom] = [
                'mois' => $moisNom,
                'reçu' => 0,
                'reste' => 0,
                'reduction' => 0,
                'total' => 0,
            ];
        }
        foreach ($ventes as $vente) {
            $mois = date('F', mktime(0, 0, 0, $vente->mois, 1));
            if (!isset($tab[$mois])) {
                $tab[$mois] = [
                    'mois' => $mois,
                    'reçu' => 0,
                    'reste' => 0,
                    'reduction' => 0,
                    'total' => 0,
                ];
            }
            $tab[$mois]['reçu'] += $vente->montant_recu;
            $tab[$mois]['reduction'] += $vente->reduction;
            $tab[$mois]['reste'] += $vente->reste;
            $tab[$mois]['total'] += $vente->montant_recu + $vente->reduction + $vente->reste;
        }
        // dd($tab);
        $tab = array_values($tab);

        
        // dd($tab);

        $labels = array_column($tab, 'mois');
        $montantRecu = array_column($tab, 'reçu');
        $reduction = array_column($tab, 'reduction');
        $reste = array_column($tab, 'reste');
        $total = array_column($tab, 'total');

        //Autres méthode
        $recus = $restes = $reductions = $totaux = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $recus[$mois] = $restes[$mois] = $reductions[$mois] = $totaux[$mois] = 0;
        }
        foreach ($ventes as $vente) {
            $recus[$vente->mois] += $vente->montant_recu;
            $restes[$vente->mois] += $vente->reste;
            $reductions[$vente->mois] += $vente->reduction;
            $totaux[$vente->mois] += $vente->montant;
        }
        $legend = ['Totaux', 'Reçus', 'Restes', 'Réductions'];
        $axis = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec'];
        // dd($recus, $restes, $reductions, $totaux);

        return view('livewire.stat-caisse',[
            'labels' => $labels,
            'montantRecu' => $montantRecu,
            'reduction' => $reduction,
            'reste' => $reste,
            'total' => $total,
            'recus' => [
                'name' => 'Reçus',
                'type' => 'line',
                'stack' => 'Total',
                'data' => array_values($recus),
            ],
            'restes' => [
                'name' => 'Restes',
                'type' => 'line',
                'stack' => 'Total',
                'data' => array_values($restes),
            ],
            'reductions' => [
                'name' => 'Réductions',
                'type' => 'line',
                'stack' => 'Total',
                'data' => array_values($reductions),
            ],
            'totaux' => [
                'name' => 'Totaux',
                'type' => 'line',
                'stack' => 'Total',
                'data' => array_values($totaux),
            ],
            'legend' => $legend,
            'axis' => $axis,
        ]);
    }
}
