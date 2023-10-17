<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Article;
use App\Models\Paiement;
use App\Models\Question;
use App\Models\LigneVente;
use App\Livewire\AppComponent;
use App\Models\Caracteristique;
use App\Models\Categorie;
use App\Models\Option;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Vente;
use App\Models\Visite as ModelsVisite;
use Illuminate\Support\Facades\Auth;
use stdClass;

class Visite extends AppComponent
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
    public $categories;
    public $selected_categorie_id;
    public $selected_categorie;
    public $caracs;
    public $artciles_added;
    public $option_modal;
    public $optionOf;
    public $options;

    public $etape4; //Facture
    public $mtt_achat;
    public $mtt_paye;
    public $mtt_reduction;

    public $panier_modal; //Panier
    public $panier;


    public function mount()
    {
        $this->panier_modal = false;
        $this->panier = null;
        $this->initEtape1();
    }

    public function initEtape1()
    {
        $this->etape1 = true;
        $this->est_identifie = false;

        $this->etape2 = false;
        $this->currentQuestion = 0;

        $this->etape3 = false;
        $this->est_concluante = false;
        $this->visite_conclue = false;
        $this->motif = 'article';
        $this->comment = null;
        $this->nature_operation = false;
        $this->est_vente = false;
        $this->artciles_added = [];
        $this->categories = null;
        $this->selected_categorie_id = null;
        $this->selected_categorie = null;
        $this->caracs = [];
        $this->option_modal = false;
        $this->optionOf = null;
        $this->options = [];

        $this->etape4 = false;
        $this->mtt_achat = null;
        $this->mtt_paye = null;
        $this->mtt_reduction = null;

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
            $client = Client::findOrFail($this->client_id);
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
        $this->etape3 = false;
        $this->etape4 = false;
        
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
        $this->etape4 = false;

        $this->est_concluante = null;
        $this->visite_conclue = null;
        $this->motif = 'article';
        $this->comment = null;
        $this->nature_operation = null;
        $this->est_vente = false;
        $this->categories = null;
        $this->selected_categorie_id = null;
        $this->selected_categorie = null;
        $this->caracs = [];
        $this->artciles_added = [];
        $this->option_modal = false;
        $this->optionOf = null;
        $this->options = [];
    }

    public function estVente(bool $value)
    {
        $this->nature_operation = true;
        $this->est_vente = $value;
    }
    public function annuleEstVente()
    {
        $this->nature_operation = false;
        $this->est_vente = null;
    }
    
    public function estConcluante(bool $value)
    {
        $this->visite_conclue = true;
        $this->est_concluante = $value;
        if($this->est_concluante)
            $this->categories = Categorie::all();
    }

    public function annuleEstConcluante()
    {
        $this->visite_conclue = false;
        $this->est_concluante = null;
    }

    public function hasCarac()
    {
        if($this->selected_categorie_id){
            $this->selected_categorie = Categorie::findOrFail($this->selected_categorie_id);
            $this->caracs = [];
            foreach($this->selected_categorie->options as $option){
                if(!in_array($option->caracteristique, $this->caracs))
                    $this->caracs[] = $option->caracteristique;
            }
        }
    }

    public function changeOption(Caracteristique $item)
    {
        $this->optionOf = $item;
        $this->option_modal = true;
    }

    public function fermer()
    {
        $this->option_modal = false;
    }

    public function addItem()
    {
        if($this->selected_categorie_id){
            $car = '';
            foreach($this->options as $optionId){
                $option = Option::findOrFail($optionId);
                $car .= "{$option->caracteristique->libelle} : {$option->libelle} |";
            }
            $this->artciles_added[$this->selected_categorie_id][] = $car;
            session()->flash('status', 'Added successfully');
            $this->selected_categorie_id = 0;
            $this->selected_categorie = null;
            $this->options = null;
        }
    }

    public function deleteItemCart(int $id)
    {
        unset($this->artciles_added[$id]);
        $this->remplirPanier();
        session()->flash('status', 'Deleted successfully');
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
        //Utilisateur
        $user = Auth::user();
        if(!$user->boutique){
            $this->addError('mtt_achat', 'Vous ne pouvez pas enregistrer une vente, car vous n\'êtes pas un commercial !!');
            return;
        }
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

            //Visite
            if($this->est_nouveau){
                $visite = new ModelsVisite();
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
            $vente = new Vente();
            if(!$this->est_concluante){
                $vente->motif = $this->motif;
                $vente->comment = nl2br($this->comment);
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
                $vente->save();
            } else{
                $vente = new Vente();
                $vente->montant = $this->mtt_achat;
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id ?? 1;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
                $vente->save();

                //Articles
                foreach($this->artciles_added as $cart => $arts){
                    foreach($arts as $carac){
                        $ligne = new LigneVente();
                        $ligne->categorie_id = $cart;
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
            }
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
        $this->artciles_added = null;
        $this->categories = null;
        $this->selected_categorie_id = null;
        $this->selected_categorie = null;
        $this->caracs = [];
        $this->artciles_added = [];
        $this->option_modal = false;
        $this->optionOf = null;
        $this->options = [];

        $this->etape4 = null; //Facture
        $this->mtt_achat = null;
        $this->mtt_paye = null;
        $this->mtt_reduction = null;
    }

    public function voirPanier()
    {
        // dd($this->panier);
        $this->remplirPanier();
        $this->panier_modal = true;
    }

    public function fermerPanier()
    {
        $this->panier_modal = false;
    }

    private function remplirPanier()
    {
        $this->panier = [];
        $item = null;
        if($this->artciles_added){
            foreach($this->artciles_added as $cat => $arts){
                foreach($arts as $carac){
                    $categorie = Categorie::findOrFail($cat);
                    $item = new stdClass();
                    $item->id = $categorie->id;
                    $item->libelle = $categorie->libelle;
                    $item->carac = $carac;
                    $this->panier[] = $item;
                }
            }
        }
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Visite')]
    public function render()
    {
        return view('livewire.visite');
    }
}
