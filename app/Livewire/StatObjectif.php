<?php

namespace App\Livewire;

use App\Models\Boutique;
use App\Models\Objectif;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class StatObjectif extends AppComponent
{
    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Objectifs')]
    public function render()
    {
        $objectif = Objectif::findOrFail(1)->montant;
        //Semaine
        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();
        $semaine_global = DB::table('ventes')
            ->select(
                DB::raw('SUM(paiements.montant) AS montant'),
            )
            ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
            ->whereBetween('ventes.date', [$debutSemaine, $finSemaine])
            ->first()
        ;
        //Mois
        $moisEnCours = Carbon::now()->startOfMonth();
        $mois_global = DB::table('ventes')
            ->select(
                DB::raw('SUM(paiements.montant) AS montant'),
            )
            ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
            ->whereYear('ventes.date', $moisEnCours->year)
            ->whereMonth('ventes.date', $moisEnCours->month)
            ->first()
        ;

        $items = null;
        $boutiques = null;
        foreach (Boutique::all() as $bout) {
            $semaine = DB::table('ventes')
                ->select(
                    DB::raw('SUM(paiements.montant) AS montant'),
                )
                ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
                ->whereBetween('ventes.date', [$debutSemaine, $finSemaine])
                ->where('ventes.boutique_id', $bout->id)
                ->first()
            ;

            $mois = DB::table('ventes')
                ->select(
                    DB::raw('SUM(paiements.montant) AS montant'),
                )
                ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
                ->whereYear('ventes.date', $moisEnCours->year)
                ->whereMonth('ventes.date', $moisEnCours->month)
                ->where('ventes.boutique_id', $bout->id)
                ->first()
            ;
            $items[] = [$semaine->montant, $mois->montant, $objectif];
            $boutiques[] = $bout->designation;
        }
        $semDeb = $debutSemaine->format('d');
        $semFin = $finSemaine->format('d');
        $mois = $debutSemaine->format('F');

        return view('livewire.stat-objectif', [
            'labels' => [
                "Semaine du {$semDeb} au {$semFin}", 
                $mois, 
                'Objectif'
            ],
            'global' => [$semaine_global->montant, $mois_global->montant, $objectif * count($items)],
            'items' => $items,
            'boutiques' => $boutiques,
        ]);
    }
}
