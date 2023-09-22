<div>
    <form wire:submit="save">
        <div class="mt-8 bg-white p-4 shadow rounded-lg">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="libelle" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                        Libellé
                    </label>
                    <input wire:model.live="libelle" id="libelle" type="text" placeholder="Article" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                    @error('libelle') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                </div>
                @if(!$this->edit_id)
                    <div class="md:w-1/2 px-3">
                        <label for="categorie" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                            Catégorie
                        </label>
                        <div class="relative">
                            <select wire:model="categorie_id" name="categorie_id" id="categorie" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                <option>Choisir une catégorie...</option>
                                @foreach ($categories as $item)
                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
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
                    <button type="button" wire:click='changeCategorie({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Changer la catégorie
                    </button>
                    <button type="button" wire:click='deleteItem({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Supprimer
                    </button>
                @endif
            </div>
        </div>
    </form>

    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les articles</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Article
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Catégorie
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $item)
                    <tr class="hover:bg-grey-lighter"
                        wire:click='editItem({{ $item->id }})'
                    >
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->libelle }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->categorie->libelle }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- changeModal -->
    @if($change_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Changer la catégorie</h5>
                    <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit="changeCategorieData">
                        <div>
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Catégorie actuelle : {{ $this->libelle }}
                            </label>
                        </div>
                        <div>
                            <label for="categorie" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Nouvelle categorie
                            </label>
                            <div class="relative">
                                <select wire:model="categorie_id" id="categorie" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                    <option>Choisir une categorie...</option>
                                    @foreach ($categories as $item)
                                        <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
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
    @endif
    <!-- deleteModal -->
    @if($confirm_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Confirmer la suppression</h5>
                    <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Suppression de &lt; {{ $this->libelle }} &gt;</p>
                </div>
                <div>
                    <button wire:click="deleteConfirmed({{ $this->delete_id }})" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Valider
                    </button>
                    <button wire:click="deleteCancelled" class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Annuler
                    </button>
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
