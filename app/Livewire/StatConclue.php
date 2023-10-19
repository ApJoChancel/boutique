<?php

namespace App\Livewire;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatConclue extends Component
{
    public function render()
    {
        $total = DB::table('visites')
            ->selectRaw("
                COUNT(visites.id) AS nombre
            ")
            ->get()
        ;

        $ventes = DB::table('reponses')
            ->selectRaw("
                choix.libelle AS choix,
                questions.libelle AS question,
                questions.id AS questionId,
                COUNT(choix.id) AS nombre
            ")
            ->join('visites', 'reponses.visite_id', 'visites.id')
            ->join('choix', 'reponses.choix_id', 'choix.id')
            ->join('questions', 'choix.question_id', 'questions.id')
            ->where('visites.conclue', true)
            // ->join('users', 'visites.user_id', 'users.id')
            // ->join('boutiques', 'users.boutique_id', 'boutiques.id')
            ->groupBy('questions.id', 'choix.id')
            ->get()
        ;
        dd($ventes);
        $questions = Question::all();
        foreach($questions as $question){
            // ${"label$question->id"} = $question->choix()->pluck('choix.libelle');
            ${"label$question->id"} = [
                
            ];
        }
        dd($label2);

        return view('livewire.stat-conclue', [
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
