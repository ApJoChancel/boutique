<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Client;
use App\Models\Article;
use App\Models\Paiement;
use App\Models\Question;
use App\Models\LigneVente;
use App\Livewire\AppComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Vente as ModelsVente;

class Vente extends AppComponent
{
    public $libelle = null;
    private $questions = null;
    private $question = null;
    public $currentQuestion = null;
    public $reponses = [];
    public $reponse = null;
    public $allResponsesAnswered = false;
    public $answered = false;
    public $selectedArticle = null;
    public $articles = null;
    public $article = null;
    public $opts = [];
    public $artcilesAdded;

    public $client = null;
    public $mtt_achat = null;
    public $mtt_paye = null;
    public $mtt_reduction = null;

    public function mount()
    {
        $this->currentQuestion = 0;
        $this->questions = Question::all();
        $this->question = $this->questions[$this->currentQuestion];

        $this->articles = Article::all();
    }

    public function submitResponse()
    {
        $this->questions = Question::all();
        $this->question = $this->questions[$this->currentQuestion];
        $this->reponses[$this->question->id] = $this->reponse;
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
        $this->article = Article::findOrFail($this->selectedArticle);
        foreach($this->article->categorie->caracteristiques as $carac){
            foreach($carac->options as $opt){
                $this->opts[$carac->id] = [
                    'carac' => $carac->libelle,
                    'option' => $opt->libelle
                ];
            }
        }
    }

    public function addItem()
    {
        $car = '';
        foreach($this->article->categorie->caracteristiques as $carac){
            $car .= "{$this->opts[$carac->id]['carac']} : {$this->opts[$carac->id]['option']} |";
        }
        $this->artcilesAdded[$this->article->id] = $car;
        $this->articles = $this->articles->filter(function ($item) {
            return $item->id !== $this->article->id;
        });
    }

    public function validVente()
    {
        $this->answered = true;
    }

    public function submitPaiement()
    {
        // dd($this->artcilesAdded, $this->reponses, $this->client, $this->mtt_achat);
        DB::beginTransaction();
            // $cli = Client::where('noms', strtolower($this->client))->first();
            $cli = null;
            if(!$cli){
                $cli = new Client();
                $cli->noms = strtolower($this->client);
                $cli->save();
            }
            $user = User::findOrFail(1);

            $vente = new ModelsVente();
            $vente->montant = $this->mtt_achat;
            $vente->client_id = $cli->id;
            $vente->user_id = $user->id;
            $vente->boutique_id = $user->boutique->id;
            $vente->date = now();
            $vente->save();

            foreach($this->reponses as $rep => $opt){
                DB::table('reponses')->insert([
                    'vente_id' => $vente->id,
                    'question_id' => $rep,
                    'choix_id' => $opt,
                ]);
            }

            foreach($this->artcilesAdded as $art => $carac){
                $ligne = new LigneVente();
                $ligne->article_id = $art;
                $ligne->vente_id = $vente->id;
                $ligne->caracteristiques = $carac;
                $ligne->save();
            }

            $paie = new Paiement();
            $paie->montant = $this->mtt_paye;
            $paie->reduction = $this->mtt_reduction;
            $paie->vente_id = $vente->id;
            $paie->date = $vente->date;
            $paie->save();
        DB::rollBack();
        $this->resetValues();
        session()->flash('status', 'Vente successfully');
    }

    public function resetValues()
    {
        
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Vente')]
    public function render()
    {
        
        return view('livewire.vente', [
            'question' => $this->question,
            'articles' => $this->articles,
        ]);
    }
}
