<div>
    <form wire:submit="save">
        <div>
            <label for="question">Question</label>
            <input wire:model="question" type="text" id="question">
        
            <div>
                <label>Les choix</label>
                @foreach($choix as $index => $choixItem)
                <div class="choix-container">
                    <div class="choix">
                        <div class="unchoix">
                            <div>
                                <label for="libelle-{{ $index }}">Libelle</label>
                                <input wire:model="choix.{{ $index }}.libelle" type="text" id="libelle-{{ $index }}">
                            </div>
                            <div>
                                <label for="type-{{ $index }}">Type de choix</label>
                                <select wire:model="choix.{{ $index }}.type" id="type-{{ $index }}" class="type">
                                    <option value="text">Text</option>
                                    <option value="unique">Unique</option>
                                    <option value="multiple">Multiple</option>
                                </select> 
                            </div>
                            <div class="complement-container">
                                <label for="complement-{{ $index }}">Options</label>
                                <textarea wire:model="choix.{{ $index }}.complement" id="complement-{{ $index }}"></textarea>
                            </div>
                            <button type="button" wire:click="removeChoix({{ $index }})">Supprimer</button>
                        </div>
                    </div>
                </div>
                @endforeach
                <button type="button"y wire:click="addChoix">Ajouter un choix</button>
            </div>
        </div>
        <input type="submit">

    </form>
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>


{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fonction pour ajouter les gestionnaires d'événements
            function addEventListenersToUnchoix() {
                const typeSelects = document.querySelectorAll('.unchoix .type');

                typeSelects.forEach(function (typeSelect) {
                    typeSelect.addEventListener('change', function () {
                        const complementContainer = this.closest('.unchoix').querySelector('.complement-container');
                        if (this.value !== 'text') {
                            complementContainer.style.display = 'block';
                        } else {
                            complementContainer.style.display = 'none';
                        }
                    });
                });
            }

            // Ajoutez les gestionnaires d'événements aux blocs "unchoix" existants
            addEventListenersToUnchoix();

            // Écoutez un événement Livewire personnalisé pour ajouter les gestionnaires d'événements aux nouveaux éléments
            Livewire.on('unchoixAdded', function () {
                addEventListenersToUnchoix();
            });
        });
    </script>
@endpush --}}