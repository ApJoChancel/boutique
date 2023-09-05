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
        <div>
            <p>Les articles achetés</p>
            <div>
                <label for="article">Article</label>
                <select wire:change.lazy='hasCarac' wire:model="selectedItem" id="article">
                    @foreach ($articles as $item)
                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                    @endforeach
                </select>
                @if ($this->article?->categorie->caracteristiques())
                    <div>
                        @foreach ($this->article->categorie->caracteristiques as $index => $item)
                            <div>
                                <label for="">{{ $item['libelle'] }}</label>
                                <select wire:model="opts.{{ $index }}.libelle">
                                    @foreach ($item->options as $opt)
                                        <option value="{{ $opt->libelle }}">{{ $opt->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                @endif
                <button wire:click='addItem' type="button">Ajouter l'article</button>
            </div>
        </div>
    @endif
</div>
