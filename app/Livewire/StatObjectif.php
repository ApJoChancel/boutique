<?php

namespace App\Livewire;

use App\Models\Boutique;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class StatObjectif extends AppComponent
{
    public function mount()
    {
        // $this->is_admin = (Auth::user()->type_id === 1) ? true : false;
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        // $this->is_admin_or_suppleant = in_array(Auth::user()->type_id, [1, 2]) ? true : false;
        //Boutiques valides
        $this->boutiques_valides = $this->boutiqueValide();
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Objectifs')]
    public function render()
    {
        // dd(Auth::user());
        // dd(Auth::user()->zone->boutiques->pluck('id')->toArray());
        
        //Semaine
        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();
        $semaine_global = DB::table('ventes')
            ->select(
                DB::raw('SUM(ventes.montant) AS montant'),
            )
            ->whereBetween('ventes.date', [$debutSemaine, $finSemaine])
            ->whereIn('ventes.boutique_id', $this->boutiques_valides)
            ->first()
        ;
        //Mois
        $moisEnCours = Carbon::now()->startOfMonth();
        $mois_global = DB::table('ventes')
            ->select(
                DB::raw('SUM(ventes.montant) AS montant'),
            )
            ->whereYear('ventes.date', $moisEnCours->year)
            ->whereMonth('ventes.date', $moisEnCours->month)
            ->whereIn('ventes.boutique_id', $this->boutiques_valides)
            ->first()
        ;

        $items = null;
        $boutiques = null;
        
        // dd($this->boutiques_valides);
        foreach (Boutique::all() as $bout) {
            if(in_array($bout->id, $this->boutiques_valides)){
                $semaine = DB::table('ventes')
                    ->select(
                        DB::raw('SUM(ventes.montant) AS montant'),
                    )
                    ->whereBetween('ventes.date', [$debutSemaine, $finSemaine])
                    ->where('ventes.boutique_id', $bout->id)
                    ->first()
                ;

                $mois = DB::table('ventes')
                    ->select(
                        DB::raw('SUM(ventes.montant) AS montant'),
                    )
                    ->whereYear('ventes.date', $moisEnCours->year)
                    ->whereMonth('ventes.date', $moisEnCours->month)
                    ->where('ventes.boutique_id', $bout->id)
                    ->first()
                ;
                $items[] = [$semaine->montant, $mois->montant, $bout->objectif];
                $boutiques[] = $bout->designation;
            }
        }
        // dd($items);
        $semDeb = $debutSemaine->format('d');
        $semFin = $finSemaine->format('d');
        $mois = $debutSemaine->format('F');

        $objectifGlobal = 0;
        foreach (Boutique::all() as $bout) {
            if(in_array($bout->id, $this->boutiques_valides)){
                $objectifGlobal += $bout->objectif;
            }
        }

        return view('livewire.stat-objectif', [
            'labels' => [
                "Semaine du {$semDeb} au {$semFin}", 
                $mois, 
                'Objectif mensuel'
            ],
            'global' => [$semaine_global->montant ?? 0, $mois_global->montant ?? 0, $objectifGlobal],
            'items' => $items,
            'boutiques' => $boutiques,
        ]);
    }
}
