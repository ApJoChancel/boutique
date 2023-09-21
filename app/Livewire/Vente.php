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
use Livewire\Attributes\Rule;

class Vente extends AppComponent
{
    // public $libelle = null;
    // private $questions = null;
    // private $question = null;
    // public $currentQuestion = null;
    // public $reponses = [];
    // public $reponse = null;
    // public $allResponsesAnswered = false;
    // public $answered = false;
    // public $selectedArticle = null;
    // public $articles = null;
    // public $article = null;
    // public $opts = [];
    // public $artcilesAdded;

    // public $client = null;
    // public $mtt_achat = null;
    // public $mtt_paye = null;
    // public $mtt_reduction = null;

    public $etape1 = false; //Identification
    public $est_nouveau = false;
    public $est_identifie = false;
    public $nom = null;
    public $prenom = null;
    public $telephone = null;
    public $client_id = null;
    public $clients = null;

    public $etape2 = false; //Sondage
    public $questions = null;
    public $question = null;
    public $currentQuestion = null;
    public $reponses = [];

    public $etape3 = false; //Articles
    public $est_concluante = false;
    public $visite_conclue = false;
    public $motif = null;
    public $comment = null;
    public $nature_operation = false;
    public $est_vente = false;
    public $articles = null;
    public $selected_article_id = null;
    public $selected_article = null;
    public $opts = null;
    public $artciles_added;

    public $etape4 = false; //Facture
    public $mtt_achat = null;
    public $mtt_paye = null;
    public $mtt_reduction = null;


    public function mount()
    {
        $this->initEtape1();
        // $this->currentQuestion = 0;
        // $this->questions = Question::all();
        // $this->question = $this->questions[$this->currentQuestion];

        // $this->articles = Article::all();
    }

    public function initEtape1()
    {
        $this->etape1 = true;
        $this->etape2 = false;

        $this->est_identifie = false;
        $this->clients = Client::all();
        $this->client_id = $this->clients[0]->id;
    }

    public function estNouveau(bool $value)
    {
        $this->est_identifie = true;;
        $this->est_nouveau = $value;
    }

    public function estIdentifie(bool $value)
    {
        $this->est_identifie = $value;
    }

    public function finEtape1()
    {
        if($this->client_id){
            $client = User::findOrFail($this->client_id);
            $this->nom = $client->nom;
            $this->prenom = $client->prenom;
            $this->telephone = $client->telephone;
        }
        $this->initEtape2();
    }

    public function initEtape2()
    {
        $this->etape2 = true;
        $this->etape1 = false;

        $this->currentQuestion = 4;
        $this->questions = Question::all();
        $this->question = $this->questions[$this->currentQuestion];
        $this->reponses[$this->currentQuestion] = ['val' => $this->reponses[$this->currentQuestion]['val'] ?? 0];
    }

    public function questionPrecedente()
    {
        if(array_key_exists($this->currentQuestion-1, $this->questions->toArray())){
            $this->currentQuestion--;
        }
        $this->question = $this->questions[$this->currentQuestion];
        $this->reponses[$this->currentQuestion] = ['val' => $this->reponses[$this->currentQuestion]['val'] ?? 0];
    }

    public function questionSuivante()
    {
        $this->currentQuestion++;
        if(array_key_exists($this->currentQuestion, $this->questions->toArray())){
            $this->question = $this->questions[$this->currentQuestion];
            $this->reponses[$this->currentQuestion] = ['val' => $this->reponses[$this->currentQuestion]['val'] ?? 0];
        } else{
            $this->initEtape3();
        }
    }

    public function initEtape3()
    {
        $this->etape3 = true;
        $this->etape1 = false;
        $this->etape2 = false;

        $this->est_concluante = false;
        $this->visite_conclue = false;
        $this->motif = 'article';
        $this->comment = null;
        $this->nature_operation = false;
        $this->est_vente = false;
        $this->articles = null;
        $this->selected_article_id = null;
        $this->selected_article = null;
        $this->opts = [];
        $this->artciles_added = [];
    }

    public function estConcluante(bool $value)
    {
        $this->visite_conclue = true;;
        $this->est_concluante = $value;
    }

    public function estVente(bool $value)
    {
        $this->nature_operation = true;;
        $this->est_vente = $value;
        $this->articles = ($this->est_vente) ? Article::all() : Article::all();
    }

    public function hasCarac()
    {
        $this->selected_article = Article::findOrFail($this->selected_article_id);
        foreach($this->selected_article->categorie->caracteristiques as $carac){
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
        foreach($this->selected_article->categorie->caracteristiques as $carac){
            $car .= "{$this->opts[$carac->id]['carac']} : {$this->opts[$carac->id]['option']} |";
        }
        $this->artciles_added[$this->selected_article->id][] = $car;
        session()->flash('status', 'Added successfully');
    }

    public function initEtape4()
    {
        $this->etape4 = true;
        $this->etape1 = false;
        $this->etape2 = false;
        $this->etape3 = false;

        $this->mtt_achat = null;
        $this->mtt_paye = null;
        $this->mtt_reduction = null;
    }

    public function venteTerminee()
    {
        //
        $this->resetValues();
        $this->initEtape1();
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
            $vente->boutique_id = $user->boutique->id ?? 6;
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
            $paie->reduction = $this->mtt_reduction ?? 0;
            $paie->vente_id = $vente->id;
            $paie->date = $vente->date;
            $paie->save();
        DB::commit();
        $this->resetValues();
        session()->flash('status', 'Vente successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        // $libelle = null;
        // $questions = null;
        // $question = null;
        // $currentQuestion = null;
        // $reponses = [];
        // $reponse = null;
        // $allResponsesAnswered = false;
        // $answered = false;
        // $selectedArticle = null;
        // $articles = null;
        // $article = null;
        // $opts = [];
        // $artcilesAdded = null;

        // $client = null;
        // $mtt_achat = null;
        // $mtt_paye = null;
        // $mtt_reduction = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Vente')]
    public function render()
    {
        return view('livewire.vente');
        // return view('livewire.vente', [
        //     'question' => $this->question,
        //     'articles' => $this->articles,
        // ]);
    }
}
