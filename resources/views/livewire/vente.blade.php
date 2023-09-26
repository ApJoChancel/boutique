<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="date_from" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Du
                </label>
                <input wire:model.live="date_from" id="date_from" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="date_to" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Au
                </label>
                <input wire:model.live="date_to" id="date_to" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
        </div>
    </div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">
            Les ventes finalisées
            <label for="montant" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                {{ $total }}
            </label>
        </h2>
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
                        Réduction accordée
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Montant reçu
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
                            {{ $item->reduction ?? 0 }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->montant_recu }}
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <button wire:click='resetValues' class="py-2 px-4 bg-transparent text-red-600 font-semibold border border-red-600 rounded hover:bg-red-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Fermer
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
