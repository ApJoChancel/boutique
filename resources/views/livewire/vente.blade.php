<div>
    @if (!$allResponsesAnswered)
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
                                                {{ $itchoixem->libelle }}
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
    @endif
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
