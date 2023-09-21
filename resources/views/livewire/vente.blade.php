<div>
    {{-- @if (!$allResponsesAnswered)
        <div>
            <h1>Question {{ $currentQuestion + 1 }}</h1>
            <p>{{ $question->libelle }}</p>
            
            <form wire:submit="submitResponse">
                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                    <div class="-mx-3 md:flex mb-2">
                        @foreach ($question->choix as $item)
                            @empty($item->choix_id)
                                @if ($item->type === 'text')
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <input wire:model="reponse" id="{{ $item->id }}" type="radio" value="{{ $item->id }}" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                                        <label for="{{ $item->id }}" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            {{ $item->libelle }}
                                        </label>
                                    </div>
                                @else
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        {{ $item->libelle }}
                                    </label>
                                    @foreach ($item->sousChoix as $choix)
                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0" style="margin-left: 3%">
                                            <input wire:model="reponse" id="{{ $choix->id }}" type="radio" value="{{ $choix->id }}" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                                            <label for="{{ $choix->id }}" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                {{ $choix->libelle }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endempty
                        @endforeach
                    </div>
                    <div>
                        <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                            Suivant
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        @if (!$answered)
            <div>
                <p>Les articles achetés</p>
                <div>
                    <div class="md:w-1/2 px-3">
                        <label for="article" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                            Article
                        </label>
                        <div class="relative">
                            <select wire:change.lazy='hasCarac' wire:model="selectedArticle" id="article" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                <option>Sélectionnez l'article...</option>
                                @foreach ($articles as $item)
                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    @if ($this->article?->categorie->caracteristiques())
                        <div>
                            @foreach ($this->article->categorie->caracteristiques as $item)
                                <div class="md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        {{ $item['libelle'] }}
                                    </label>
                                    <div class="relative">
                                        <select wire:model="opts.{{ $item->id }}.option" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                            @foreach ($item->options as $opt)
                                                <option value="{{ $opt->libelle }}">{{ $opt->libelle }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <button wire:click='addItem' type="button" wire:click='changeOptions({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Ajouter l'article
                    </button>
                    <button wire:click='validVente' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Valider
                    </button>
                </div>
            </div>
        @else
            <form wire:submit="submitPaiement">
                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                    <div class="-mx-3 md:flex mb-2">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="client" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Client
                            </label>
                            <input wire:model.live="client" id="client" type="text" placeholder="Catégorie" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('client') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-2">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="mtt_achat" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Montant des achats
                            </label>
                            <input wire:model.live="mtt_achat" id="mtt_achat" type="text" placeholder="Catégorie" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('mtt_achat') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-2">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="mtt_paye" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Montant payé
                            </label>
                            <input wire:model.live="mtt_paye" id="mtt_paye" type="text" placeholder="Catégorie" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('mtt_paye') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-2">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="mtt_reduction" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Réduction accordée
                            </label>
                            <input wire:model.live="mtt_reduction" id="mtt_reduction" type="text" placeholder="Catégorie" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('mtt_reduction') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                            Valider la vente
                        </button>
                        <button  wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                            Annuler
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @endif --}}
    {{--  --}}
    @if ($etape1)
        @if (!$est_identifie)
            <div>
                <p>Nouveau ou ancien ?</p>
                <div>
                    <button wire:click='estNouveau(true)' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Nouveau
                    </button>
                    <button wire:click='estNouveau(false)' type="button" class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Ancien
                    </button>
                </div>
            </div>
        @else
            <form wire:submit="finEtape1">
                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                    @if ($est_nouveau)
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="nom" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    nom
                                </label>
                                <input wire:model.live="nom" id="nom" type="text" placeholder="Ex : COM0102" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('nom') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="prenom" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    prenom
                                </label>
                                <input wire:model.live="prenom" id="prenom" type="text" placeholder="Ex : DOE" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('prenom') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="telephone" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    telephone
                                </label>
                                <input wire:model.live="telephone" id="telephone" type="text" placeholder="Ex : John" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('telephone') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @else
                        <div class="md:w-1/2 px-3">
                            <label for="client" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Client
                            </label>
                            <div class="relative">
                                <select wire:model="client_id" name="client_id" id="client" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                    <option>Choisir un client...</option>
                                    @foreach ($clients as $item)
                                        <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ "{$item->nom} {$item->prenom}" }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                                @error('client_id') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Suivant
                    </button>
                    <button wire:click='estIdentifie(false)' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Retour
                    </button>
                </div>
            </form>
        @endif
    @else
        @if ($etape2)
            <div>
                <h1>Question {{ $currentQuestion + 1 }}/{{ count($questions) }}</h1>
                <p>{{ $question->libelle }}</p>
                
                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                    <div class="-mx-3 md:flex mb-2">
                        @foreach ($question->choix as $item)
                            @empty($item->choix_id)
                                @if ($item->type === 'text')
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <input wire:model="reponses.{{ $currentQuestion }}.val" id="{{ $item->id }}" type="radio" value="{{ $item->id }}" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                                        <label for="{{ $item->id }}" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            {{ $item->libelle }}
                                        </label>
                                    </div>
                                @else
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        {{ $item->libelle }}
                                    </label>
                                    @foreach ($item->sousChoix as $choix)
                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0" style="margin-left: 3%">
                                            <input wire:model="reponses.{{ $currentQuestion }}.val" id="{{ $choix->id }}" type="radio" value="{{ $choix->id }}" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                                            <label for="{{ $choix->id }}" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                {{ $choix->libelle }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endempty
                        @endforeach
                    </div>
                    <div>
                        @if ($currentQuestion > 0)
                            <button  wire:click='questionPrecedente' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Précédent
                            </button>
                        @endif
                        <button wire:click='questionSuivante' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                            Suivant
                        </button>
                    </div>
                </div>
            </div>
            <button wire:click='initEtape1' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                Etape précédente
            </button>
        @else
            @if ($etape3)
                @if (!$nature_operation)
                    <div>
                        <p>Vente ou location ?</p>
                        <div>
                            <button wire:click='estVente(true)' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Vente
                            </button>
                            <button wire:click='estVente(false)' type="button" class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Location
                            </button>
                        </div>
                    </div>
                @else
                    @if (!$visite_conclue) {{--  --}}
                        <div>
                            <p>Visite concluante ?</p>
                            <div>
                                <button wire:click='estConcluante(true)' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Oui
                                </button>
                                <button wire:click='estConcluante(false)' type="button" class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Non
                                </button>
                            </div>
                        </div>
                    @else
                        @if (!$est_concluante) {{--  --}}
                            <div>
                                <h1>Motif</h1>
                                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                    <div class="-mx-3 md:flex mb-2">
                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                            <label for="motif" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                Elément défaillant
                                            </label>
                                            <div class="relative">
                                                <select wire:model="motif" id="motif" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                    <option>Choisir un motif...</option>
                                                    <option value="article">Article</option>
                                                    <option value="modele">Modèle</option>
                                                    <option value="taille">Taille</option>
                                                    <option value="couleur">Couleur</option>
                                                    <option value="prix">Prix</option>
                                                </select>
                                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                            <label for="comment" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                Commentaire
                                            </label>
                                            <textarea wire:model="comment" id="comment" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"></textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <button wire:click='venteTerminee' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                            Terminer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h1>{{ ($est_vente) ? 'VENTE' : 'LOCATION' }}</h1>
                            <div>
                                <p>Les articles sollicités</p>
                                <div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="article" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Article
                                        </label>
                                        <div class="relative">
                                            <select wire:change.lazy='hasCarac' wire:model="selected_article_id" id="article" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                <option>Choisir un article...</option>
                                                @foreach ($articles as $item)
                                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($this->selected_article?->categorie->caracteristiques())
                                        <div>
                                            @foreach ($this->selected_article->categorie->caracteristiques as $item)
                                                <div class="md:w-1/2 px-3">
                                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                        {{ $item['libelle'] }}
                                                    </label>
                                                    <div class="relative">
                                                        <select wire:model="opts.{{ $item->id }}.option" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                            @foreach ($item->options as $opt)
                                                                <option value="{{ $opt->libelle }}">{{ $opt->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <button wire:click='addItem' type="button" wire:click='changeOptions({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                        Ajouter l'article
                                    </button>
                                    <button wire:click='initEtape4' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                        Passer à la facturation
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
                <button wire:click='initEtape2' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    Etape précédente
                </button>
            @else
                @if ($etape4)
                    <div class="mt-8 bg-white p-4 shadow rounded-lg">
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="mtt_achat" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Montant des achats
                                </label>
                                <input wire:model.live="mtt_achat" id="mtt_achat" type="text" placeholder="Ex : 500000" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('mtt_achat') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="mtt_paye" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Montant payé
                                </label>
                                <input wire:model.live="mtt_paye" id="mtt_paye" type="text" placeholder="Ex: 500000" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('mtt_paye') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="mtt_reduction" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Réduction accordée
                                </label>
                                <input wire:model.live="mtt_reduction" id="mtt_reduction" type="text" placeholder="Ex : 10000" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                @error('mtt_reduction') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <button wire:click='venteTerminee' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Terminer la vente
                            </button>
                        </div>
                    </div>
                    <button wire:click='initEtape3' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Etape précédente
                    </button>
                @endif
            @endif
        @endif
    @endif
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
