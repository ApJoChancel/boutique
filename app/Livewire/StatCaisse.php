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
            DB::raw('MONTH(paiements.date) AS mois'),
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('ventes.montant - SUM(paiements.montant + paiements.reduction) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->whereYear('paiements.date', $this->year)
        ->whereIn('ventes.boutique_id', $this->boutiques_valides)
        ->groupBy('mois', 'ventes.montant')
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
        $tab = array_values($tab);

        // dd($tab);

        $labels = array_column($tab, 'mois');
        $montantRecu = array_column($tab, 'reçu');
        $reduction = array_column($tab, 'reduction');
        $reste = array_column($tab, 'reste');
        $total = array_column($tab, 'total');

        return view('livewire.stat-caisse',[
            'labels' => $labels,
            'montantRecu' => $montantRecu,
            'reduction' => $reduction,
            'reste' => $reste,
            'total' => $total,
        ]);
    }
}
