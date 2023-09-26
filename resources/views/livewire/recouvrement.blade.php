<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les ventes en cours</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Date de vente
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Client
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Montant vente
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Montant reçu
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Réduction accordée
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Reste à percevoir
                    </th><th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Téléphone
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventes as $item)
                    <tr class="hover:bg-grey-lighter"
                        wire:click='infoItem({{ $item->vente_id }})'
                    >
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->date_vente }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ "{$item->nom} {$item->prenom}" }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->montant_vente }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->montant_recu }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->reduction ?? 0 }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->reste }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->telephone }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- infoModal -->
    @if($info_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Détails de la vente</h5>
                    <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @if ($vente)
                    <div class="modal-body">
                        <div>
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Vente N° 00{{ $vente->id }}
                            </label>
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Articles
                            </label>
                        </div>
                        <div>
                            <table class="w-full table-auto text-sm">
                                <tbody>
                                    @foreach ($vente->ligneVentes as $item)
                                        <tr class="hover:bg-grey-lighter">
                                            <td class="py-2 px-4 border-b border-grey-light">
                                                {{ $item->article->libelle }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-grey-light">
                                                {{ $item->caracteristiques }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Paiements
                            </label>
                        </div>
                        <div>
                            <table class="w-full table-auto text-sm">
                                <tbody>
                                    @foreach ($vente->paiements as $item)
                                        <tr class="hover:bg-grey-lighter">
                                            <td class="py-2 px-4 border-b border-grey-light">
                                                {{ $item->date }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-grey-light">
                                                {{ $item->montant }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-grey-light">
                                                {{ $item->reduction }}
                                            </td>                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <button wire:click="paiementItem({{ $vente?->id }})" type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Nouveau paiement
                            </button>
                            <button wire:click='resetValues' class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Fermer
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- paieModal -->
    @if($paie_modal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-lg font-semibold">Paiement de la vente</h5>
                    <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit="paiementItemData({{ $vente?->id }})">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="montant" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Montant
                            </label>
                            <input wire:model.live="montant" id="montant" type="text" placeholder="Ex : 500000" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('montant') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="reduction" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                Réduction
                            </label>
                            <input wire:model.live="reduction" id="reduction" type="text" placeholder="Ex : 500000" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                            @error('reduction') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
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