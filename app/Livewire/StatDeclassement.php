<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;

class StatDeclassement extends AppComponent
{
    public function render()
    {
        $ventes = DB::table('ventes')
        ->select(
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('ventes.montant - SUM(paiements.montant + paiements.reduction) AS reste')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->groupBy('paiements.vente_id')
        ->get();

        return view('livewire.stat-declassement');
    }
}
