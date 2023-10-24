<?php

namespace App\Livewire;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class StatConclue extends Component
{
    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Visites conclues')]
    public function render()
    {
        $total = DB::table('visites')
            ->selectRaw("
                COUNT(visites.id) AS nombre
            ")
            ->first()
        ;

        $total_conclue = DB::table('visites')
            ->selectRaw("
                COUNT(visites.id) AS nombre
            ")
            ->where('visites.conclue', true)
            ->first()
        ;
        // dd($total);
        $sondage = DB::table('reponses')
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
        // dd($sondage);
        // $questions = Question::all();
        $tab = [];
        foreach($sondage as $vente){
            // ${"label$question->id"} = $question->choix()->pluck('choix.libelle');
            $tab[$vente->question][$vente->choix] = $vente->nombre;
        }
        foreach(Question::all() as $question){
            foreach($question->choix as $choix){
                if(!isset($tab[$question->libelle][$choix->libelle]))
                    $tab[$question->libelle][$choix->libelle] = 0;
            }
        }
        // dd($tab);
        $i = 0;
        $all = [];
        foreach($tab as $question => $reponses){
            $all[$i]['titre'] = $question;
            $all[$i]['label'] = array_keys($reponses);
            $all[$i]['totaux'] = array_values($reponses);
            $i++;
        }
        // dd($all);

        return view('livewire.stat-conclue', [
            'datas' => $all,
            'total' => $total->nombre,
            'total_conclue' => $total_conclue->nombre,
        ]);
    }
}
