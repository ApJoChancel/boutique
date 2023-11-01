<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Paiement;
use App\Models\Question;
use App\Models\LigneVente;
use App\Livewire\AppComponent;
use App\Models\Boutique;
use App\Models\Caracteristique;
use App\Models\Categorie;
use App\Models\Option;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Vente;
use App\Models\Visite as ModelsVisite;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use stdClass;

class Visite extends AppComponent
{
    public $etape1; //Identification
    public $est_nouveau;
    public $est_identifie;
    #[Rule('required')]
    public $nom;
    #[Rule('required')]
    public $prenom;
    #[Rule('required')]
    public $telephone;
    #[Rule('required')]
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
    public $boutiques;
    public $boutique_modal;
    public $boutique_id;
    public $count_panier;

    public $etape4; //Facture
    public $total_achat;
    public $total_reduc;
    public $total_recu;

    public $panier_modal; //Panier
    public $panier;


    public function mount()
    {
        $this->panier_modal = false;
        $this->panier = [];
        $this->initEtape1();
    }

    public function initEtape1()
    {
        $this->etape1 = true;
        $this->est_identifie = false;
        $this->nom = null;
        $this->prenom = null;
        $this->telephone = null;
        $this->client_id = null;
        
        $this->etape2 = false;
        $this->currentQuestion = 0;
        $this->reponses = null;

        $this->etape3 = false;
        $this->est_concluante = false;
        $this->visite_conclue = false;
        $this->motif = 'article';
        $this->comment = null;
        $this->nature_operation = false;
        $this->est_vente = false;
        // $this->artciles_added = [];
        // $this->count_panier = 0;
        $this->categories = null;
        $this->selected_categorie_id = null;
        $this->selected_categorie = null;
        $this->caracs = [];
        $this->option_modal = false;
        $this->optionOf = null;
        $this->options = [];
        $this->boutiques = null;
        $this->boutique_modal = false;
        $this->boutique_id = null;

        $this->etape4 = false;
        $this->total_achat = 0;
        $this->total_reduc = 0;
        $this->total_recu = 0;

        $this->clients = Client::all();
        $this->client_id = null;
    }

    public function estNouveau(bool $value)
    {
        $this->est_identifie = true;
        $this->est_nouveau = $value;
    }

    public function estIdentifie(bool $value)
    {
        $this->est_identifie = $value;
    }

    public function finEtape1()
    {
        if($this->est_nouveau){
            $this->validateOnly('nom');
            $this->validateOnly('prenom');
            $this->validateOnly('telephone');
        } else{
            $this->validateOnly('client_id');
        }
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
        $this->resetValidation();

        if(!$this->est_nouveau){
            //On récupère la dernière visite du client
            $lastVisite = DB::table('visites')
                ->where('client_id', $this->client_id)
                ->orderByDesc('id')
                ->first()
            ;
            $last = ModelsVisite::findOrFail($lastVisite->id);
            $i = 0;
            foreach ($last->reponses as $choix) {
                $this->reponses[$i] = ['val' => $choix->id];
                $i++;
            }
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

    public function passer()
    {
        $this->initEtape3();
    }

    public function questionPrecedente()
    {
        $this->resetValidation();

        if(array_key_exists($this->currentQuestion-1, $this->questions->toArray())){
            $this->currentQuestion--;
        }
        $this->question = $this->questions[$this->currentQuestion];
        $this->reponses[$this->currentQuestion] = ['val' => $this->reponses[$this->currentQuestion]['val'] ?? 0];
    }

    public function questionSuivante()
    {
        $this->resetValidation();

        if(empty($this->reponses[$this->currentQuestion]['val'])){
            $this->addError('uneReponse', 'Une réponse est obligatoire');
            return;
        }
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
        $this->artciles_added = $this->artciles_added ?? [];
        $this->count_panier = self::count_recursive($this->artciles_added, 1);
        self::remplirPanier();
        $this->option_modal = false;
        $this->optionOf = null;
        $this->options = [];
        $this->boutiques = null;
        $this->boutique_modal = false;
        $this->boutique_id = null;
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
        $this->resetValidation();
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
        if(!array_key_exists($this->optionOf->id, $this->options)){
            $this->options[$this->optionOf->id] =
                ($this->optionOf->type === 'unique') ? '' : [];
        }
        
        $this->option_modal = true;
    }

    public function fermer()
    {
        $this->option_modal = false;
        $this->boutique_modal = false;
    }

    public function addItem()
    {
        // dd($this->caracs, $this->options);
        $this->resetValidation();
        if($this->selected_categorie_id){
            if(!$this->caracs){
                $this->addError('panier', 'Renseignez les caractéristiques');
                return;
            }
            if(!$this->options){
                $this->addError('panier', 'Renseignez les caractéristiques');
                return;
            }
            if(count($this->caracs) != count($this->options)){
                $this->addError('panier', 'Renseignez toutes les caractéristiques de la catégorie');
                return;
            }
            $car = '';
            $ids = [];
            foreach($this->options as $caracteristiqueId => $opts){
                $carac = Caracteristique::findOrFail($caracteristiqueId);
                if(!is_array($opts)){
                    $ids[] = $opts;
                    $opt = Option::findOrFail($opts);
                    $car .= "{$carac->libelle} : {$opt->libelle} |";
                } else{
                    $car .= "{$carac->libelle} : ";
                    foreach($opts as $optId){
                        $ids[] = $optId;
                        $opt = Option::findOrFail($optId);
                        $car .= "{$opt->libelle},";
                    }
                    $car .= " |";
                }
            }

            $this->artciles_added[$this->selected_categorie_id][] = [
                'categorie' => $this->selected_categorie->libelle,
                'option_ids' => implode(',', $ids),
                'carac_texte' => $car,
                'qte' => null,
                'prix' => null,
                'reduction' => null
            ];
            $this->count_panier = self::count_recursive($this->artciles_added, 1);
            session()->flash('status', 'Added successfully');
            $this->selected_categorie_id = 0;
            $this->selected_categorie = null;
            $this->options = [];
            $this->optionOf = null;
            $this->caracs = [];
        } else{
            $this->addError('panier', 'Veuillez choisir une catégorie');
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
        if(count($this->artciles_added) < 1){
            $this->addError('panier', 'Il faut au moins un article dans le panier');
            return;
        }
        $this->etape4 = true;
        $this->etape1 = false;
        $this->etape2 = false;
        $this->etape3 = false;

        // self::remplirPanier();
        // dd($this->panier[0]);
        $this->panier = [];
        $item = null;
        if($this->artciles_added){
            foreach($this->artciles_added as $cat => $arts){
                foreach($arts as $art){
                    $categorie = Categorie::findOrFail($cat);
                    $item = [];
                    $item['id'] = $categorie->id;
                    $item['categorie'] = $categorie->libelle;
                    $item['option_ids'] = $art['option_ids'];
                    $item['carac_texte'] = $art['carac_texte'];
                    $item['qte'] = $art['qte'];
                    $item['prix'] = $art['prix'];
                    $item['reduction'] = $art['reduction'];
                    $this->panier[] = $item;
                }
            }
        }
    }

    public function venteTerminee()
    {
        // dd($this->total_recu);

        $this->resetValidation();
        $this->boutique_modal = false;
        //On s'assure que les prix et qte sont correctes
        if($this->est_concluante){
            foreach ($this->panier as $item) {
                if (($item['prix'] < 1) || ($item['qte'] < 1)){
                    $this->addError('prix', 'Doit être un nombre non nul');
                    $this->addError('qte', 'Doit être un nombre non nul');
                    return;
                }
            }
        }

        //Utilisateur
        $user = Auth::user();
        // dd($user->boutique);
        if(!$user->boutique && !$this->boutique_id){
            $this->boutiques = Boutique::all();
            $this->boutique_modal = true;
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
            $visite = new ModelsVisite();
            $visite->client_id = $cli->id;
            $visite->user_id = $user->id;
            $visite->boutique_id = $user->boutique->id ?? $this->boutique_id;
            $visite->date = now();
            $visite->conclue = ($this->est_concluante) ? true : false;
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

            //Vente
            $vente = new Vente();
            if(!$this->est_concluante){
                if(empty($this->motif)){
                    $this->addError('motif', 'Le motif est obligatoire');
                    return;
                }
                if(empty($this->comment)){
                    $this->addError('comment', 'Le commentaire est obligatoire');
                    return;
                }
                $vente->motif = $this->motif;
                $vente->comment = nl2br($this->comment);
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id ?? $this->boutique_id;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
                $vente->save();
            } else{
                $vente = new Vente();
                $vente->montant = $this->total_achat;
                $vente->client_id = $cli->id;
                $vente->user_id = $user->id;
                $vente->boutique_id = $user->boutique->id ?? $this->boutique_id;
                $vente->date = now();
                $vente->type = ($this->est_vente) ? 'vente' : 'location';
                $vente->save();

                //Articles
                foreach($this->panier as $art){
                    $ligne = new LigneVente();
                    $ligne->categorie_id = $art['id'];
                    $ligne->vente_id = $vente->id;
                    $ligne->option_ids = $art['option_ids'];
                    $ligne->carac_texte = $art['carac_texte'];
                    $ligne->qte = $art['qte'];
                    $ligne->prix = $art['prix'];
                    $ligne->reduction = $art['reduction'] ?? 0;
                    $ligne->save();
                }

                //Paiement
                $paie = new Paiement();
                $paie->montant = $this->total_recu;
                $paie->reduction = $this->total_reduc;
                $paie->vente_id = $vente->id;
                $paie->date = $vente->date;
                $paie->save();
            }
        DB::commit();
        $this->resetValues();
        $this->initEtape1();
        session()->flash('status', 'Vente successfully');
    }

    public function calculAchat()
    {
        $this->total_achat = 0;
        $this->total_reduc = 0;
        foreach ($this->panier as $item) {
            $this->total_achat += (is_numeric($item['prix']) && is_numeric($item['qte'])) ?
                ($item['prix'] * $item['qte']) : 0;
            $this->total_reduc += $item['reduction'];
        }
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
        $this->boutiques = null;
        $this->boutique_modal = false;
        $this->boutique_id = null;
        $this->count_panier = 0;

        $this->etape4 = null; //Facture
        $this->total_achat = 0;
        $this->total_reduc = 0;
        $this->total_recu = 0;
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
                foreach($arts as $art){
                    $categorie = Categorie::findOrFail($cat);
                    $item = new stdClass();
                    $item->id = $categorie->id;
                    $item->categorie = $categorie->libelle;
                    $item->option_ids = $art['option_ids'];
                    $item->carac_texte = $art['carac_texte'];
                    $item->qte = $art['qte'];
                    $item->prix = $art['prix'];
                    $item->reduction = $art['reduction'];
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
