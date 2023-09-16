<div>
    <!-- deleteModal -->
    {{-- <div wire:ignore.self class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Confirmer la suppression</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Suppression de &lt; {{ $this->noms }} &gt;</p>
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
    </div> --}}
    
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
    <form wire:submit="register">
        <div class="mt-8 bg-white p-4 shadow rounded-lg">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="email" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                        Email
                    </label>
                    <input wire:model.live="email" id="email" type="email" placeholder="chancel@domain.net" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                    @error('email') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="noms" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                        Noms et prénoms
                    </label>
                    <input wire:model.live="noms" id="noms" type="text" placeholder="chancel" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                    @error('noms') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                </div>
                @empty($this->edit_id)
                    <div class="md:w-1/2 px-3">
                        <label for="role" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                            Role
                        </label>
                        <div class="relative">
                            <select wire:model="role_id" name="role_id" id="role" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                <option disabled>Choisir un rôle...</option>
                                @foreach ($roles as $item)
                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                @endempty
            </div>
            <div>
                <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    {{ $this->textSubmit }}
                </button>
                <button  wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    Annuler
                </button>
                @if ($this->edit_id)
                    <button type="button" wire:click='resetPassword({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-blue-600 font-semibold border border-blue-600 rounded hover:bg-blue-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Réinitialiser le mot de passe
                    </button>
                    <button type="button" wire:click='deleteItem({{ $this->edit_id }})' class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                        Supprimer
                    </button>
                @endif
            </div>
        </div>
    </form>

    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les utilisateurs</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Email
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Noms et prénoms
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Role
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr class="hover:bg-grey-lighter"
                        wire:click='editItem({{ $item->id }})'
                    >
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->email }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->noms }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->role->libelle }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
