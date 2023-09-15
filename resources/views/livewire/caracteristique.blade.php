<div>
    <form wire:submit="save">
        <div class="mt-8 bg-white p-4 shadow rounded-lg">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="libelle" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                        Libellé
                    </label>
                    <input wire:model.live="libelle" id="libelle" type="text" placeholder="Caractéristique" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                    @error('libelle') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                </div>
                @if(!$this->edit_id)
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="options" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                            Options
                        </label>
                        <textarea wire:model="options" name="options" id="options" cols="20" rows="5" placeholder="Option" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"></textarea>
                        @error('options') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
            <div>
                <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    {{ $this->textSubmit }}
                </button>
                <button  wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    Annuler
                </button>
                @if ($this->edit_id)
                    <button type="button" wire:click='changeOptions({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Changer les options
                    </button>
                @endif
            </div>
        </div>
    </form>

    
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les caractéristiques</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Caractéristique
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($caracteristiques as $item)
                    <tr class="hover:bg-grey-lighter"
                        wire:click='editItem({{ $item->id }})'
                    >
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->libelle }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- deleteModal -->
    <div wire:ignore.self class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Confirmer la suppression</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Suppression de &lt; {{ $this->libelle }} &gt;</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" wire:click="deleteConfirmed({{ $this->delete_id }})">
                        Valider
                    </button>
                    <button class="btn btn-primary btn-sm" wire:click="deleteCancelled" data-bs-dismiss="modal">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- changeModal -->
    <div wire:ignore.self class="modal fade" id="changeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Changer les options</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="changeOptionData">
                        <div>
                            <label>Caractéristiques : {{ $this->libelle }}</label>
                        </div>
                        <div>
                            <label for="options">Options</label>
                            <textarea wire:model="options" name="options" id="options" cols="20" rows="5"></textarea>
                        </div>
            
                        <div>
                            <input type="submit" value="{{ $this->textSubmit }}">
                            <input wire:click='resetValues' type="reset" value="Annuler">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
