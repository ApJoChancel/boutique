<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Vente extends AppComponent
{
    public $libelle = null;
    private $questions = null;
    private $question = null;
    public $currentQuestion = null;
    public $reponses = [];
    public $reponse = null;
    public $allResponsesAnswered = false;
    public $selectedItem = null;
    public $articles = null;
    public $article = null;
    public $opts = [];

    public function mount()
    {
        $this->currentQuestion = 4;
        $this->questions = Question::all();
        $this->question = $this->questions[$this->currentQuestion];

        $this->articles = Article::all();
    }

    public function submitResponse()
    {
        $this->questions = Question::all();
        $this->question = $this->questions[$this->currentQuestion];
        $this->reponses[] = [
            $this->question->id => $this->reponse
        ];
        $this->reponse = null;
        $this->currentQuestion++;
        if(array_key_exists($this->currentQuestion, $this->questions->toArray())){
            $this->questions = Question::all();
            $this->question = $this->questions[$this->currentQuestion];
        } else{
            $this->allResponsesAnswered = true;
        }
    }

    public function hasCarac()
    {
        $this->article = Article::findOrFail($this->selectedItem);
        foreach($this->article->categorie->caracteristiques as $index => $carac){
            foreach($carac->options as $opt){
                $this->opts[$index] = [
                    'libelle' => $opt->libelle
                ];
            }

        }
    }

    public function addItem()
    {
        dd($this->opts);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Vente')]
    public function render()
    {
        return view('livewire.vente', [
            'question' => $this->question,
        ]);
    }
}
