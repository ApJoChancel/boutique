<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Gestion des boutiques') }}
                    </h2>
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
                    <form wire:submit="save">
                        <div>
                            <x-label for="designation" :value="__('Designation')" />
                            <x-input wire:model.live="designation" id="designation" type="text" placeholder="Ex : Agence 1" class="block mt-1 w-full" />
                            @error('designation') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                        @empty($this->edit_id)
                            <div class="mt-4">
                                <x-label for="objectif" :value="__('Objectif mensuel')" />
                                <x-input wire:model.live="objectif" id="objectif" type="text" placeholder="Ex : 2000000" class="block mt-1 w-full" />
                                @error('objectif') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="mt-4">
                                <x-label for="zone" :value="__('Zone')" />
                                <x-forms.select wire:model="zone_id" id="zone_id" class="block mt-1 w-full">
                                    <option>Choisir une zone...</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}" wire:key="{{ $zone->id }}">
                                            {{ $zone->libelle }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                                @error('zone_id') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="mt-4">
                                <x-label for="user" :value="__('Manager')" />
                                <x-forms.select wire:model="user_id" id="user_id" class="block mt-1 w-full">
                                    <option>Choisir un manager...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" wire:key="{{ $user->id }}">
                                            {{ "{$user->nom} {$user->prenom}" }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                                @error('user_id') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endempty
            
                        <div class="flex items-center justify-end mt-4">
                            @if (!$this->edit_id)
                                <x-button class="ml-4">
                                    {{ __('Enregistrer') }}
                                </x-button>
                            @endif
                            <button  wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Annuler
                            </button>
                            @if ($this->edit_id)
                                <button type="button" wire:click='changeManager({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Changer le manager
                                </button>
                                <button type="button" wire:click='changeZone({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Changer la zone
                                </button>
                                <button type="button" wire:click='changeObjectif({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Changer l'objectif
                                </button>
                                <button type="button" wire:click='deleteItem({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                    Supprimer
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    {{-- <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="search" type="search" id="search" placeholder="Search" required name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </div>
                    </div> --}}
                    <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($boutiques as $item)
                                <tr class="border-2"
                                    wire:click='editItem({{ $item->id }})'
                                >
                                    <x-table.td>{{ $item->designation }}</x-table.td>
                                    <x-table.td>{{ $item->zone->libelle }}</x-table.td>
                                    <x-table.td>{{ "{$item->manager?->nom} {$item->manager?->prenom}" }}</x-table.td>
                                    <x-table.td>{{ formatNombre($item->objectif) }}</x-table.td>
                                </tr>
                            @endforeach
                        </x-table.table>
                        {{ $boutiques->links() }}
                    </div>
                </div>
            </div>
        </section>

        <!-- changeModal -->
        @if($change_modal)
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg font-semibold">Changer</h5>
                        <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($this->change_zone)
                            <form wire:submit="changeZoneData">
                                <div>
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Zone actuelle : {{ $this->designation }}
                                    </label>
                                </div>
                                <div>
                                    <label for="zone" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Nouvelle zone
                                    </label>
                                    <div class="relative">
                                        <select wire:model="zone_id" id="zone" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                            <option>Choisir une zone...</option>
                                            @foreach ($zones as $item)
                                                <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                        @error('boutique_id') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
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
                        @elseif ($this->change_objectif)
                            <form wire:submit="changeObjectifData">
                                <div>
                                    <x-label for="objectif" :value="__('Objectif mensuel')" />
                                    <x-input wire:model="objectif" id="objectif" type="text" placeholder="Ex : 2000000" class="block mt-1 w-full" />
                                    @error('objectif') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
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
                        @else
                            <form wire:submit="changeManagerData">
                                <div>
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Manager actuel : {{ $this->designation }}
                                    </label>
                                </div>
                                <div>
                                    <label for="user" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Nouveau manager
                                    </label>
                                    <div class="relative">
                                        <select wire:model="user_id" id="user" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                            <option>Choisir une manager...</option>
                                            @foreach ($users as $item)
                                                <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ "{$item->nom} {$item->prenom}" }}</option>
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
                        @endif
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
                        <p>Suppression de &lt; {{ $this->designation }} &gt;</p>
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
    </div>
</div>
