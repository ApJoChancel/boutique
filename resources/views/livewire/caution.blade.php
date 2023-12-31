<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Les cautions') }}
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
                    </div>
                    {{-- <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($cautions as $item)
                                <tr class="border-2"
                                    wire:click='infoItem({{ $item->id }})'
                                >
                                    <x-table.td>{{ formatDateLong($item->vente->date) }}</x-table.td>
                                    <x-table.td>{{ "{$item->vente->client->nom} {$item->vente->client->prenom}" }}</x-table.td>
                                    <x-table.td>{{ formatNombre($item->caution) }}</x-table.td>
                                    <x-table.td>{{ formatDateLong($item->date_limite) }}</x-table.td>
                                    <x-table.td>
                                        @if (!$item->date_retour)
                                            En attente du retour
                                        @else
                                            @if (!$item->est_finalisee)
                                                En attente de validation
                                            @else
                                                @if (!$item->est_remboursee)
                                                    Caution levée
                                                @else
                                                    Caution remboursée
                                                @endif
                                            @endif
                                        @endif
                                    </x-table.td>
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
                                        if(
                                            ($vente->caution) &&
                                            (in_array($vente->boutique_id, $boutiques_valides))
                                        )
                                            $rows += 1;
                                    }
                                    $i = 0;
                                @endphp
                                @foreach ($client->ventes as $vente)
                                    @if (
                                        ($vente->caution) &&
                                        (in_array($vente->boutique_id, $boutiques_valides))
                                    )
                                        @php
                                            $i++;
                                        @endphp
                                        <tr class="border-2"
                                            wire:click='infoItem({{ $vente->caution->id }})'
                                            @if ($vente->caution->est_remboursee) style="color: green;" @endif
                                        >
                                            @if ($i === 1)
                                                <x-table.td
                                                    rowspan="{{ $rows }}"
                                                >
                                                    {{ "{$client->nom} {$client->prenom}" }}
                                                </x-table.td>
                                            @endif
                                            <x-table.td>{{ formatDateLong($vente->date) }}</x-table.td>
                                            <x-table.td>{{ $vente->boutique->designation }}</x-table.td>
                                            <x-table.td>{{ formatNombre($vente->caution->caution) }}</x-table.td>
                                            <x-table.td>{{ formatDateLong($vente->caution->date_limite) }}</x-table.td>
                                            <x-table.td>
                                                @if (!$vente->caution->date_retour)
                                                    En attente du retour
                                                @else
                                                    @if (!$vente->caution->est_finalisee)
                                                        En attente de validation
                                                    @else
                                                        @if (!$vente->caution->est_remboursee)
                                                            Caution levée
                                                        @else
                                                            Caution remboursée
                                                        @endif
                                                    @endif
                                                @endif
                                            </x-table.td>
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
                        <h5 class="text-lg font-semibold">Détails de la caution</h5>
                        <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @if ($caution)
                        <div class="modal-body">
                            <div>
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Vente N° 00{{ $caution->vente->id }}
                                </label>
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Montant des achats : {{ formatNombre($caution->vente->montant) }}
                                </label>
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Client : {{ "{$caution->vente->client->nom} {$caution->vente->client->prenom}" }}
                                </label>
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                    Articles
                                </label>
                            </div>
                            <div>
                                <table class="w-full table-auto text-sm">
                                    <tbody>
                                        @foreach ($caution->vente->ligneVentes as $item)
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
                                        @foreach ($caution->vente->paiements as $item)
                                            <tr class="hover:bg-grey-lighter">
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatDateLong($item->date) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($item->montant) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ $item->reduction }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($caution->date_retour)
                                <div>
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Demande de levée
                                    </label>
                                </div>
                                <div>
                                    <table class="w-full table-auto text-sm">
                                        <thead>
                                            <tr>
                                                <th>Date limite</th>
                                                <th>Date de retour</th>
                                                <th>Niveau de dégradation</th>
                                                <th>Caution</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-grey-lighter">
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatDateCourte($caution->date_limite) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatDateCourte($caution->date_retour) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ $caution->niveau_degradation ?? 0 }}%
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($caution->caution) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            @if ($caution->est_finalisee)
                                <div>
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Validation de la levée
                                    </label>
                                </div>
                                <div>
                                    <table class="w-full table-auto text-sm">
                                        <thead>
                                            <tr>
                                                <th>Caution</th>
                                                <th>Pénalité délais</th>
                                                <th>Pénalité état</th>
                                                <th>À rendre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-grey-lighter">
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($caution->caution) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($caution->penalite_date) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($caution->penalite_degradation) }}
                                                </td>
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatNombre($caution->caution - ($caution->penalite_date + $caution->penalite_degradation))  }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            @if ($caution->est_remboursee)
                                <div>
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Remboursement
                                    </label>
                                </div>
                                <div>
                                    <table class="w-full table-auto text-sm">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-grey-lighter">
                                                <td class="py-2 px-4 border-b border-grey-light">
                                                    {{ formatDateLong($caution->date_remboursee) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div>
                                @if (!$caution->date_retour)
                                    @if ($is_com)
                                        <button wire:click="demandeLeverCautionItem({{ $caution->id }})" type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                            Demande de levée
                                        </button>
                                    @endif
                                @else
                                    @if (!$caution->est_finalisee)
                                        @if ($is_admin_or_suppleant)
                                            <button wire:click="demandeLeverCautionItem({{ $caution->id }})" type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                Valider la demande
                                            </button>
                                        @endif
                                    @else
                                        @if (!$caution->est_remboursee)
                                            @if ($is_com)
                                                <button wire:click="confirmRembour({{ $caution->id }})" type="button" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                                    Confirmer le remboursement
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                @endif

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
                        <h5 class="text-lg font-semibold">Demande de levée de caution</h5>
                        <button wire:click="deleteCancelled()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (!$caution->date_retour)
                            <form wire:submit="demandeLeverCautionItemData({{ $caution->id }})">
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label for="delais" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Date de retour de l'article
                                    </label>
                                    <input wire:model.live="delais" id="delais" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                    @error('delais') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label for="etat" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                        Etat de dégradation de l'article
                                    </label>
                                    <x-forms.select wire:model="etat" id="etat" class="block mt-1 w-full">
                                        <option value="0">0%</option>
                                        <option value="10">10%</option>
                                        <option value="20">20%</option>
                                        <option value="30">30%</option>
                                    </x-forms.select>
                                    @error('etat') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
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
                            <form wire:submit="validationLeverCautionItemData({{ $caution->id }})">
                                @if (strtotime($caution->date_retour) > strtotime($caution->date_limite))
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="penalite_delais" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Pénalité délais
                                        </label>
                                        <input wire:model.live="penalite_delais" id="penalite_delais" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                        @error('penalite_delais') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                    </div>
                                @endif

                                @if ($caution->niveau_degradation > 0)
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="penalite_etat" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Pénalité état
                                        </label>
                                        <input wire:model.live="penalite_etat" id="penalite_etat" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                        @error('penalite_etat') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                                    </div>
                                @endif
                                @if ((strtotime($caution->date_retour) > strtotime($caution->date_limite)) && ($caution->niveau_degradation > 0))
                                    <p>Aucune pénalité</p>
                                @endif
                                
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
    </div>
</div>