<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class StatDeclassement extends AppComponent
{
    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Déclassement')]
    public function render()
    {
        $ventes = DB::table('ventes')
        ->select(
            'ventes.type AS type',
            'clients.nom AS nom',
            'clients.prenom AS prenom',
            'clients.telephone AS telephone',
            'ventes.montant AS montant_vente',
            DB::raw('SUM(paiements.montant) AS montant_recu'),
            DB::raw('SUM(paiements.reduction) AS reduction'),
            DB::raw('ventes.montant - SUM(paiements.montant + paiements.reduction) AS reste'),
            DB::raw('DATEDIFF(CURDATE(), ventes.date) AS jours_ecoules')
        )
        ->leftJoin('paiements', 'ventes.id', 'paiements.vente_id')
        ->leftJoin('clients', 'ventes.client_id', 'clients.id')
        ->groupBy('ventes.montant', 'ventes.date', 'ventes.type', 'clients.nom', 'clients.prenom', 'clients.telephone')
        ->having('reste', '>', 0)
        ->get();

        return view('livewire.stat-declassement', [
            'ventes' => $ventes
        ]);
    }
}
