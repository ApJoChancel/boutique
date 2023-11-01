<div>
    <!-- panierModal -->
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
                                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                                Votre Panier : {{ $count_panier }}
                                                @switch($count_panier)
                                                    @case(0)
                                                    @case(1)
                                                        article
                                                        @break
                                                    @default
                                                        articles
                                                @endswitch
                                            </h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button wire:click='fermerPanier' type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="absolute -inset-0.5"></span>
                                                    <span class="sr-only">Fermer</span>
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
                                                                                {{ $item->categorie }}
                                                                            </h3>
                                                                        </div>
                                                                        <p class="mt-1 text-sm text-gray-500">{{ $item->carac_texte }}</p>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Visites') }}
                        @if ($etape3 && $est_concluante)
                            <button class="relative" wire:click='voirPanier'>
                                <i class="fas fa-shopping-cart text-gray-500 text-lg"></i>
                                <span class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center absolute -top-1 -right-1 text-xs">
                                    {{ $count_panier }}
                                </span>
                            </button>
                        @endif
                    </h2>
                    <p class="font-semibold text-xl">
                        @if ($etape4)
                            1️⃣ 2️⃣ 3️⃣ 4️⃣
                        @elseif ($etape3)
                            @if (!$nature_operation)
                                1️⃣ 2️⃣ 3️⃣ ◾ ◽ ◽ ◻️
                            @elseif (!$visite_conclue)
                                1️⃣ 2️⃣ 3️⃣ ◾ ◾ ◽ ◻️
                            @else
                                1️⃣ 2️⃣ 3️⃣ ◾ ◾ ◾ ◻️
                            @endif
                        @elseif ($etape2)
                            1️⃣ 2️⃣ ◻️ ◻️
                        @else
                            1️⃣ ◻️ ◻️ ◻️
                        @endif
                    </p>
                    <p class="font-semibold text-xl">
                        @if ($etape4)
                            Facturation
                        @elseif ($etape3)
                           Informations sur la visite
                            @if (!$nature_operation)
                                > Nature de la visite
                            @elseif (!$visite_conclue)
                                > Visite conclue ?
                            @else
                                > Finaliser la visite
                            @endif
                        @elseif ($etape2)
                            Sondage
                        @else
                           Identification du visiteur
                        @endif
                    </p>
                    @if (session()->has('status'))
                        <div class="fixed bottom-0 right-0 m-4" id="toast">
                            <div class="bg-blue-500 border-l-4 border-blue-700 py-2 px-3 rounded-lg shadow-md">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <span class="text-white">{{ session('status') }}</span>
                                    </div>
                                    <button class="text-white ml-5" wire:click="closeToast">&times;</button>
                                </div>
                            </div>
                        </div>
                    @endif 
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($etape1)
                        @if (!$est_identifie)
                            <div class="flex items-center justify-center">
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
                                <div class="flex items-center justify-center flex-col">
                                    <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                        @if ($est_nouveau)
                                            <div class="-mx-3 md:flex mb-2">
                                                <div>
                                                    <label for="nom" class="block text-sm font-medium leading-6 text-gray-900">
                                                        nom
                                                    </label>
                                                    <input wire:model.live="nom" id="nom" type="text" placeholder="Ex : ZOCK" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                    @error('nom') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                </div>
                                                <div>
                                                    <label for="prenom" class="block text-sm font-medium leading-6 text-gray-900">
                                                        prenom
                                                    </label>
                                                    <input wire:model.live="prenom" id="prenom" type="text" placeholder="Ex : Corlette" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                    @error('prenom') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                </div>
                                                <div>
                                                    <label for="telephone" class="block text-sm font-medium leading-6 text-gray-900">
                                                        telephone
                                                    </label>
                                                    <input wire:model.live="telephone" id="telephone" type="text" placeholder="Ex : 658 65 98 00" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                    @error('telephone') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                        @else
                                            <div class="md:w-1/2 px-3">
                                                <label for="client" class="block text-sm font-medium leading-6 text-gray-900">
                                                    Client
                                                </label>
                                                <div class="relative">
                                                    <select wire:model="client_id" name="client_id" id="client" class="block appearance-none bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
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
                                        <button wire:click='estIdentifie(false)' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                            Retour
                                        </button>
                                        <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                            Suivant
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @else
                        @if ($etape2)
                            <div>
                                <div class="lg:flex lg:items-center lg:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                            Question {{ $currentQuestion + 1 }}/{{ count($questions) }}
                                        </h2>
                                        <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $question->libelle }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-center flex-col">
                                    <div class="mb-2">
                                        @foreach ($question->choix as $item)
                                            <div class="flex items-center gap-x-3">
                                                <input wire:model="reponses.{{ $currentQuestion }}.val" id="{{ $item->id }}" type="radio" value="{{ $item->id }}" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                <label for="{{ $item->id }}" class="block text-sm font-medium leading-6 text-gray-900">
                                                    {{ $item->libelle }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('uneReponse') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        @if ($currentQuestion > 0)
                                            <button  wire:click='questionPrecedente' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
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
                            @if (!$this->est_nouveau)
                                <button wire:click='passer' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Passer cette étape
                                </button>
                            @endif
                        @else
                            @if ($etape3)
                                @if (!$nature_operation)
                                    <div class="flex items-center justify-center flex-col">
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
                                        <div class="flex items-center justify-center flex-col">
                                            <div>
                                                <button wire:click='estConcluante(false)' type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                    Non concluante
                                                </button>
                                                <button wire:click='estConcluante(true)' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                    Concluante
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        @if (!$est_concluante)
                                            <div>
                                                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                                    <div class="-mx-3 md:flex mb-2">
                                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                                            <label for="motif" class="block text-sm font-medium leading-6 text-gray-900">
                                                                Elément défaillant
                                                            </label>
                                                            <div class="relative">
                                                                <select wire:model="motif" id="motif" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                                    <option value="0">Choisir un motif...</option>
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
                                                            @error('motif') <p class="mt-4 text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                        </div>
                                                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                                            <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">
                                                                Commentaire
                                                            </label>
                                                            <textarea wire:model="comment" id="comment" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"></textarea>
                                                            @error('comment') <p class="mt-4 text-grey-dark text-xs italic">{{ $message }}</p> @enderror
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
                                            <div class="min-w-0 flex-1">
                                                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                                    {{ ($est_vente) ? 'Vente' : 'Location' }}
                                                </h2>
                                            </div>
                                            <div class="flex items-center justify-center flex-col">
                                                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                                    <div class="md:w-1/2 px-3 mb-2">
                                                        <label for="categorie" class="block text-sm font-medium leading-6 text-gray-900">
                                                            Categorie
                                                        </label>
                                                        <div class="relative">
                                                            <select wire:change.lazy='hasCarac' wire:model="selected_categorie_id" id="categorie" class="block appearance-none bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                                                <option value="0">Choisir une categorie...</option>
                                                                @foreach ($categories as $item)
                                                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                            </div>
                                                        </div>
                                                        @error('panier') <p class="mt-4 text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                    </div>
                                                    @if ($this->caracs)
                                                        <div>
                                                            <x-label :value="__('Caractéristiques')" />
                                                            @foreach ($this->caracs as $item)
                                                                <x-label wire:click='changeOption({{ $item->id }})' value="{{ $item->libelle }}" class="inline mr-3" />
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                                    <button wire:click='addItem' type="button" wire:click='changeOptions({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                        Ajouter au panier
                                                    </button>
                                                    <button wire:click='initEtape4' type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                        Passer à la facturation
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <button @if ($est_nouveau) wire:click='initEtape2' @else wire:click='initEtape1' @endif type="button" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Etape précédente
                                </button>
                                @if ($nature_operation != null)
                                    <button @if ($visite_conclue != null) wire:click='annuleEstConcluante' @else wire:click='annuleEstVente' @endif type="button" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                        <
                                    </button>
                                @endif
                            @else
                                @if ($etape4)
                                    <div class="min-w-0 flex-1">
                                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                            Facture
                                        </h2>
                                    </div>
                                    <div class="flex items-center justify-center flex-col">
                                        <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                            @for ($i = 0; $i < count($panier); $i++)
                                                <div class="-mx-3 md:flex mb-2">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3>
                                                                {{ $panier[$i]['categorie'] }}
                                                            </h3>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500">{{ $panier[$i]['carac_texte'] }}</p>
                                                    </div>
                                                    <div>
                                                        <label for="qte" class="block text-sm font-medium leading-6 text-gray-900">
                                                            Quantité
                                                        </label>
                                                        <input wire:blur='calculAchat' wire:model="panier.{{ $i }}.qte" id="qte" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                        @error('qte') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div>
                                                        <label for="prix" class="block text-sm font-medium leading-6 text-gray-900">
                                                            Prix
                                                        </label>
                                                        <input wire:blur='calculAchat' wire:model="panier.{{ $i }}.prix" id="prix" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                        @error('prix') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div>
                                                        <label for="reduction" class="block text-sm font-medium leading-6 text-gray-900">
                                                            Réduction
                                                        </label>
                                                        <input wire:blur='calculAchat' wire:model="panier.{{ $i }}.reduction" id="reduction" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                        @error('reduction') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="mt-8 bg-white p-4 shadow rounded-lg">
                                            <div class="-mx-3 md:flex mb-2">
                                                <div>
                                                    <label for="achat" class="block text-sm font-medium leading-6 text-gray-900">
                                                        Total Achat
                                                    </label>
                                                    <input id="achat" value="{{ $total_achat }}" disabled type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                </div>
                                                <div>
                                                    <label for="reduc" class="block text-sm font-medium leading-6 text-gray-900">
                                                        Total Réduction
                                                    </label>
                                                    <input id="reduc" value="{{ $total_reduc }}" disabled type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                </div>
                                                <div>
                                                    <label for="recu" class="block text-sm font-medium leading-6 text-gray-900">
                                                        Montant reçu
                                                    </label>
                                                    <input id="recu" wire:model='total_recu' type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-8 bg-white p-4 shadow rounded-lg">
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
            </div>
        </div>
    </div>

    <!-- optionModal -->
    @if($option_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Choisir les caractéristiques</h5>
                    <button wire:click="fermer" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            @foreach ($optionOf->options as $option)
                                @if (in_array($option->id, $selected_categorie->options->pluck('id')->toArray()))
                                    <x-input wire:model="options.{{ $optionOf->id }}" value="{{ $option->id }}" id="{{ $option->id }}" 
                                        :type="$optionOf->type === 'unique' ? 'radio' : 'checkbox'" class="inline" />
                                    <x-label for="{{ $option->id }}" value="{{ $option->libelle }}" class="inline mr-3" />
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <span wire:click='fermer' class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0"">
                                Valider
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- boutiqueModal -->
    @if($boutique_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Choisir la boutique</h5>
                    <button wire:click="fermer" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            @foreach ($this->boutiques as $boutique)
                                <div>
                                    <x-input wire:model="boutique_id" value="{{ $boutique->id }}" id="{{ $boutique->id }}" type="radio" class="inline" />
                                    <x-label for="{{ $boutique->id }}" value="{{ $boutique->designation }}" class="inline mr-3" />
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <span wire:click='venteTerminee' class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0"">
                                Valider
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
