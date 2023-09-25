<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class StatCaisse extends Component
{
    public $year = null;

    public function mount()
    {
        $this->year = '2023';
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
                ];
            }
            $tab[$mois]['reçu'] += $vente->montant_recu;
            $tab[$mois]['reduction'] += $vente->reduction;
            $tab[$mois]['reste'] += $vente->reste;
        }
        $tab = array_values($tab);

        // dd($tab);

        $labels = array_column($tab, 'mois');
        $montantRecu = array_column($tab, 'reçu');
        $reduction = array_column($tab, 'reduction');
        $reste = array_column($tab, 'reste');

        return view('livewire.stat-caisse',[
            'labels' => $labels,
            'montantRecu' => $montantRecu,
            'reduction' => $reduction,
            'reste' => $reste,
        ]);
    }
}
