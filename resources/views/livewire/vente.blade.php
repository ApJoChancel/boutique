<div>
    @if (!$allResponsesAnswered)
        <div>
            <h1>Question {{ $currentQuestion + 1 }}</h1>
            <p>{{ $question->libelle }}</p>
            
            <form wire:submit.prevent="submitResponse">
                <div>
                    @foreach ($question->choix as $item)
                        @empty($item->choix_id)
                            @if ($item->type === 'text')
                                <div>
                                    <input wire:model='reponse' id="{{ $item->id }}" type="radio" value="{{ $item->id }}">
                                    <label for="{{ $item->id }}">{{ $item->libelle }}</label>
                                </div>
                            @else
                                <label>{{ $item->libelle }}</label>
                                @foreach ($item->sousChoix as $choix)
                                    <div style="margin-left: 3%">
                                        <input wire:model='reponse' id="{{ $choix->id }}" type="radio" value="{{ $choix->id }}">
                                        <label for="{{ $choix->id }}">{{ $choix->libelle }}</label>
                                    </div>
                                @endforeach
                            @endif
                        @endempty
                    @endforeach
                </div>

                <button>Suivant</button>
            </form>
        </div>
    @else
        @if (!$answered)
            <div>
                <p>Les articles achetés</p>
                <div>
                    <label for="article">Article</label>
                    <select wire:change.lazy='hasCarac' wire:model="selectedArticle" id="article">
                        @foreach ($this->articles as $item)
                            <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                        @endforeach
                    </select>
                    @if ($this->article?->categorie->caracteristiques())
                        <div>
                            @foreach ($this->article->categorie->caracteristiques as $item)
                                <div>
                                    <label for="">{{ $item['libelle'] }}</label>
                                    <select wire:model="opts.{{ $item->id }}.option">
                                        @foreach ($item->options as $opt)
                                            <option value="{{ $opt->libelle }}">{{ $opt->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <button wire:click='addItem' type="button">Ajouter l'article</button>
                    <button wire:click='validVente' type="button">Valider</button>
                </div>
            </div>
        @else
            <form wire:submit.prevent='submitPaiement'>
                <div>
                    <label for="client">Client</label>
                    <input wire:model='client' type="text" id="client">
                </div>
                <div>
                    <label for="mtt_achat">Montant des achats</label>
                    <input wire:model='mtt_achat' type="text" id="mtt_achat">
                </div>
                <div>
                    <label for="mtt_paye">Montant payé</label>
                    <input wire:model='mtt_paye' type="text" id="mtt_paye">
                </div>
                <div>
                    <label for="mtt_reduction">Réduction accordée</label>
                    <input wire:model='mtt_reduction' type="text" id="mtt_reduction">
                </div>
                <button>Valider la vente</button>
            </form>        
        @endif
    @endif
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
