<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Les évènements') }}
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
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($events as $item)
                                <tr class="border-2">
                                    <x-table.td>{{ formatDateLong($item->date_event) }}</x-table.td>
                                    <x-table.td>{{ $item->libelle }}</x-table.td>
                                    <x-table.td>{{ "{$item->vente->client->nom} {$item->vente->client->prenom}" }}</x-table.td>
                                    <x-table.td>{{ $item->vente->client->telephone }}</x-table.td>
                                    <x-table.td>
                                        <button class="btn btn-primary btn-sm" wire:click="fermer({{ $item->id }})">
                                            Fermer
                                        </button>
                                    </x-table.td>
                                </tr>
                            @endforeach
                        </x-table.table>
                    </div>
                </div>
            </div>
        </section>

        <!-- infoModal -->
        {{-- @if($info_modal)
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
        @endif --}}
    </div>
</div>
