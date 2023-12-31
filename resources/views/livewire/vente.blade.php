<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Les ventes finalisées') }}
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
                    <div>
                        <x-label for="date_from" :value="__('Du')" />
                        <x-input wire:model.live="date_from" id="date_from" type="date" />
                    </div>
                    <div>
                        <x-label for="date_to" :value="__('Au')" />
                        <x-input wire:model.live="date_to" id="date_to" type="date" />
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                {{-- <input wire:model.debounce.500ms="search" type="search" id="search" placeholder="Search" required name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"> --}}
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <div class="min-w-0 flex-1">
                                <h2 style="text-align: right" class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                    Total reçu : {{ formatNombre($total) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($ventes as $item)
                                <tr class="border-2"
                                    wire:click='infoItem({{ $item->vente_id }})'
                                >
                                    <x-table.td>{{ "{$item->nom} {$item->prenom}" }}</x-table.td>
                                    <x-table.td>{{ formatDateLong($item->date_vente) }}</x-table.td>
                                    <x-table.td>{{ $item->type }}</x-table.td>
                                    <x-table.td>{{ formatNombre($item->montant_vente) }}</x-table.td>
                                    <x-table.td>{{ formatNombre($item->reduction) ?? 0 }}</x-table.td>
                                    <x-table.td>{{ formatNombre($item->montant_recu) }}</x-table.td>
                                </tr>
                            @endforeach
                        </x-table.table>
                    </div> --}}
                    <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($clients as $client)
                                @php
                                    $rows = 0;
                                    foreach ($client->ventes as $vente) {
                                        $recu = $vente->paiements->sum('montant');
                                        $reduction = $vente->paiements->sum('reduction');
                                        $reste = $vente->montant - ($recu + $reduction);
                                        if((
                                            (in_array($vente->boutique_id, $boutiques_valides)) &&
                                            ($vente->date >= $date_from && $vente->date <= $date_to ) &&
                                            ($vente->montant > 0) &&
                                            ($reste === 0)
                                        ))
                                            $rows += 1;
                                    }
                                    $i = 0;
                                @endphp
                                @foreach ($client->ventes as $vente)
                                    @php
                                        $recu = $vente->paiements->sum('montant');
                                        $reduction = $vente->paiements->sum('reduction');
                                        $reste = $vente->montant - ($recu + $reduction);
                                    @endphp
                                    @if (
                                        (in_array($vente->boutique_id, $boutiques_valides)) &&
                                        ($vente->date >= $date_from && $vente->date <= $date_to ) &&
                                        ($vente->montant > 0) &&
                                        ($reste === 0)
                                    )
                                        @php
                                            $i++;
                                        @endphp
                                        <tr class="border-2"
                                            wire:click='infoItem({{ $vente->id }})'
                                        >
                                            @if ($i === 1)
                                                <x-table.td
                                                    rowspan="{{ $rows }}"
                                                >
                                                    {{ "{$client->nom} {$client->prenom}" }}
                                                </x-table.td>
                                            @endif
                                            <x-table.td>{{ formatDateLong($vente->date) }}</x-table.td>
                                            <x-table.td>{{ $vente->type }}</x-table.td>
                                            <x-table.td>{{ formatNombre($vente->montant) }}</x-table.td>
                                            <x-table.td>{{ formatNombre($reduction) ?? 0 }}</x-table.td>
                                            <x-table.td>{{ formatNombre($recu) }}</x-table.td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </x-table.table>
                    </div>
                </div>
            </div>
        </section>

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
                                    Client : {{ "{$vente->client->nom} {$vente->client->prenom}" }}
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
                                                    {{ $item->categorie->libelle }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ $item->carac_texte }}
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
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Montant reçu</th>
                                            <th>Réduction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vente->paiements as $item)
                                            <tr class="hover:bg-grey-lighter">
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatDateLong($item->date) }}
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
</div>
