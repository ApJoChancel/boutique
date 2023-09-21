<?php

namespace App\Livewire;

use App\Models\Objectif;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class StatObjectif extends Component
{
    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Objectifs')]
    public function render()
    {
        $objectif = Objectif::findOrFail(1)->montant;
        //Semaine
        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();
        $semaine = DB::table('ventes')
            ->select(
                DB::raw('SUM(ventes.montant) AS montant'),
            )
            ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
            ->whereBetween('ventes.date', [$debutSemaine, $finSemaine])
            ->first()
        ;
        //Mois
        $moisEnCours = Carbon::now()->startOfMonth();
        $mois = DB::table('ventes')
            ->select(
                DB::raw('SUM(ventes.montant) AS montant'),
            )
            ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
            ->whereYear('ventes.date', $moisEnCours->year)
            ->whereMonth('ventes.date', $moisEnCours->month)
            ->first()
        ;

        return view('livewire.stat-objectif', [
            'labels' => ['Semaine', 'Mois', 'Objectif'],
            'datas' => [$semaine->montant, $mois->montant, $objectif],
        ]);
    }
}
