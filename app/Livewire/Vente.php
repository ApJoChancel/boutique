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
use App\Models\Visite;
use Illuminate\Support\Facades\Auth;

class Vente extends AppComponent
{
    public $etape1; //Identification
    public $est_nouveau;
    public $est_identifie;
    public $nom;
    public $prenom;
    public $telephone;
    public $client_id;
    public $clients;

    public $etape2; //Sondage
    public $questions;
    public $question;
    public $currentQuestion;
    public $reponses;

    public $etape3; //Articles
    public $est_concluante;
    public $visite_conclue;
    public $motif;
    public $comment;
    public $nature_operation;
    public $est_vente;
    public $articles;
    public $selected_article_id;
    public $selected_article;
    public $opts;
    public $artciles_added;

    public $etape4; //Facture
    public $mtt_achat;
    public $mtt_paye;
    public $mtt_reduction;


    public function mount()
    {
        $this->initEtape1();
    }

    public function initEtape1()
    {
        $this->etape1 = true;
        $this->etape2 = false;

        $this->est_identifie = false;
        $this->clients = Client::all();
        $this->client_id = null;
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
        if(!$this->est_nouveau){
            $this->initEtape3();
            return;
        }
        $this->etape2 = true;
        $this->etape1 = false;

        $this->currentQuestion = 0;
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

    public function estVente(bool $value)
    {
        $this->nature_operation = true;;
        $this->est_vente = $value;
    }
    
    public function estConcluante(bool $value)
    {
        $this->visite_conclue = true;;
        $this->est_concluante = $value;
        if($this->est_concluante)
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
        DB::beginTransaction();
            //Client
            $cli = null;
            if(!$this->client_id){
                $cli = new Client();
                $cli->nom = $this->nom;
                $cli->prenom = $this->prenom;
                $cli->telephone = $this->telephone;
                $cli->save();
            } else{
                $cli = Client::findOrFail($this->client_id);
            }

            //Utilisateur
            $user = Auth::user();

            //Visite
            if($this->est_nouveau){
                $visite = new Visite();
                $visite->client_id = $cli->id;
                $visite->user_id = $user->id;
                $visite->boutique_id = $user->boutique->id;
                $visite->date = now();
                $visite->save();
                //Le sondage
                foreach($this->reponses as $opt){
                    DB::table('reponses')->insert([
                        'visite_id' => $visite->id,
                        'choix_id' => $opt['val'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            //Vente
            $vente = new ModelsVente();
            if(!$this->est_concluante){
                $visite->motif = $this->motif;
                $visite->comment = nl2br($this->comment);
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
            } else{
                $vente = new ModelsVente();
                $vente->montant = $this->mtt_achat;
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id ?? 1;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
            }
            $vente->save();

            //Articles
            foreach($this->artciles_added as $art => $arts){
                foreach($arts as $carac){
                    $ligne = new LigneVente();
                    $ligne->article_id = $art;
                    $ligne->vente_id = $vente->id;
                    $ligne->caracteristiques = $carac;
                    $ligne->save();
                }
            }

            //Paiement
            $paie = new Paiement();
            $paie->montant = $this->mtt_paye;
            $paie->reduction = $this->mtt_reduction ?? 0;
            $paie->vente_id = $vente->id;
            $paie->date = $vente->date;
            $paie->save();
        DB::commit();
        $this->resetValues();
        $this->initEtape1();
        session()->flash('status', 'Vente successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->etape1 = null; //Identification
        $this->est_nouveau = null;
        $this->est_identifie = null;
        $this->nom = null;
        $this->prenom = null;
        $this->telephone = null;
        $this->client_id = null;
        $this->clients = null;

        $this->etape2 = null; //Sondage
        $this->questions = null;
        $this->question = null;
        $this->currentQuestion = null;
        $this->reponses = null;

        $this->etape3 = null; //Articles
        $this->est_concluante = null;
        $this->visite_conclue = null;
        $this->motif = null;
        $this->comment = null;
        $this->nature_operation = null;
        $this->est_vente = null;
        $this->articles = null;
        $this->selected_article_id = null;
        $this->selected_article = null;
        $this->opts = null;
        $this->artciles_added = null;

        $this->etape4 = null; //Facture
        $this->mtt_achat = null;
        $this->mtt_paye = null;
        $this->mtt_reduction = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Vente')]
    public function render()
    {
        return view('livewire.vente');
    }
}
