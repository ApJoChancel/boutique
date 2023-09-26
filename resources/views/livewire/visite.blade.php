<div>
    <div class="space-x-5">
        <button wire:click='voirPanier'>
            <i class="fas fa-shopping-cart text-gray-500 text-lg"></i>
        </button>
    </div>
    <div style="margin-top: 40px">
        @if ($etape1)
            @if (!$est_identifie)
                <div>
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
                        <div class="mb-2">
                            @foreach ($question->choix as $item)
                                @empty($item->choix_id)
                                    @if ($item->type === 'text')
                                        <div class="flex items-center mb-2">
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
                                            <div class="flex items-center mb-2yyyy" style="margin-left: 3%">
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
                            <button wire:click='questionSuivante' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Suivant
                            </button>
                            @if ($currentQuestion > 0)
                                <button  wire:click='questionPrecedente' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Précédent
                                </button>
                            @endif
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
                        @if (!$visite_conclue)
                            <div>
                                <div>
                                    <button wire:click='estConcluante(true)' type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                        Visite concluante
                                    </button>
                                    <button wire:click='estConcluante(false)' type="button" class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                        Visite non concluante
                                    </button>
                                </div>
                            </div>
                        @else
                            @if (!$est_concluante) {{--  --}}
                                <div>
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
                                    <div>
                                        <div class="md:w-1/2 px-3">
                                            <label for="article" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                                Article
                                            </label>
                                            <div class="relative">
                                                <select wire:change.lazy='hasCarac' wire:model="selected_article_id" id="article" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                    <option value="0">Choisir un article...</option>
                                                    @foreach ($articles as $item)
                                                        <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($this->selected_article?->categorie?->caracteristiques())
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
    </div>

    {{-- <!-- panierModal -->
    @if($panier_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Changer les options</h5>
                    <button wire:click="fermerPanier()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit="changeOptionData">
                        <div>
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Caractéristiques : {{ $this->libelle }}
                            </label>
                        </div>
                        <div>
                            <label for="options" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Options
                            </label>
                            <textarea wire:model="options" id="options" rows="5" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                {{ $this->textSubmit }}
                            </button>
                            <button wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif --}}

    @if($panier_modal)
        <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                            <div class="pointer-events-auto w-screen max-w-md">
                                <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                    <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button wire:click='fermerPanier' type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="absolute -inset-0.5"></span>
                                                    <span class="sr-only">Close panel</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                        
                                        <div class="mt-8">
                                            <div class="flow-root">
                                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                    @foreach ($panier as $item)
                                                        @if ($item)
                                                            <li class="flex py-6">
                                                                <div class="ml-4 flex flex-1 flex-col">
                                                                    <div>
                                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                                            <h3>
                                                                                {{ $item->libelle }}
                                                                            </h3>
                                                                        </div>
                                                                        <p class="mt-1 text-sm text-gray-500">{{ $item->carac }}</p>
                                                                    </div>
                                                                    <div class="flex flex-1 items-end justify-between text-sm">
                                                                        <div class="flex">
                                                                            <button wire:click='deleteItemCart({{ $item->id }})' type="button" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                                                Suprimer
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <div class="mt-6">
                                            <button wire:click='fermerPanier' class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('status'))
        <div class="fixed bottom-0 right-0 m-4" id="toast">
            <div class="bg-blue-500 border-l-4 border-blue-700 py-2 px-3 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center py-2">
                        <span class="text-white">{{ session('status') }}</span>
                    </div>
                    <button class="text-white ml-5" wire:click="closeToast">&times;</button>
                </div>
            </div>
        </div>
    @endif
</div>
