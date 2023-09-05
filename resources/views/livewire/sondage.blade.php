<div>
    <form wire:submit="save">
        <div>
            <label for="question">Question</label>
            <input wire:model="question" type="text" id="question">
        
            <div>
                <label>Les choix</label>
                @foreach($choix as $index => $choixItem)
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
                            <div class="complement-container" style="display: none">
                                <label for="complement-{{ $index }}">Options</label>
                                <textarea wire:model="choix.{{ $index }}.complement" id="complement-{{ $index }}"></textarea>
                            </div>
                            <button type="button" wire:click="removeChoix({{ $index }})">Supprimer</button>
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


@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('change', '.type', function () {
                const complementContainer = $(this).closest('.unchoix').find('.complement-container');
                if ($(this).val() !== 'text') {
                    complementContainer.show();
                } else {
                    complementContainer.hide();
                }
            });

            Livewire.on('update-script', function () {
                // Réexécutez votre script JavaScript ici
                $(document).on('change', '.type', function () {
                    const complementContainer = $(this).closest('.unchoix').find('.complement-container');
                    if ($(this).val() !== 'text') {
                        complementContainer.show();
                    } else {
                        complementContainer.hide();
                    }
                });
            });
        });
    </script>
@endpush