<div>
    {{-- <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les ventes en cours</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ as $item)
                    <tr class="hover:bg-grey-lighter">
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{  }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item-> }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item-> }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item-> }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item-> }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            
                        </td>
                        @for ($i = 0, $j = 0, $k = 7; $i < 4; $i++, $j += 7, $k += 7)
                            <td class="py-2 px-4 border-b border-grey-light
                                @if ($item->type === 'vente')
                                    @if (
                                        $item->jours_ecoules > (45 + $j) &&
                                        $item->jours_ecoules <= (45 + $k)
                                    )
                                        bg-red-200
                                    @endif
                                @else
                                    @if (
                                        $item->jours_ecoules > (30 + $j) &&
                                        $item->jours_ecoules <= (30 + $k)
                                    )
                                        bg-red-200
                                    @endif
                                @endif 
                            ">
                                
                            </td>
                        @endfor
                        <td class="py-2 px-4 border-b border-grey-light
                            @if ($item->type === 'vente')
                                @if ($item->jours_ecoules > (45 + 28))
                                    bg-red-200
                                @endif
                            @else
                                @if ($item->jours_ecoules > (30 + 28))
                                    bg-red-200
                                @endif
                            @endif
                        ">
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Tableau de déclassement') }}
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
                                <input wire:model.debounce.500ms="search" type="search" id="search" placeholder="Search" required name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <h2 style="text-align: right" class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $total }}
                            </h2>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <x-table.table :headers="$headers">
                            @foreach ($ventes as $item)
                                <tr class="border-2">
                                    <x-table.td>{{ "{$item->nom} {$item->prenom}" }}</x-table.td>
                                    <x-table.td>{{ $item->type }}</x-table.td>
                                    <x-table.td>{{ $item->montant_vente }}</x-table.td>
                                    <x-table.td>{{ $item->reste }}</x-table.td>
                                    <x-table.td>{{ $item->telephone }}</x-table.td>
                                    <x-table.td>
                                        @if ($item->type === 'vente')
                                            @if ($item->jours_ecoules < 45)
                                                Oui {{ $item->jours_ecoules }}
                                            @endif
                                        @else
                                            @if ($item->jours_ecoules < 30)
                                                Oui {{ $item->jours_ecoules }}
                                            @endif
                                        @endif
                                    </x-table.td>
                                    @for ($i = 0, $j = 0, $k = 7; $i < 4; $i++, $j += 7, $k += 7)
                                        <x-table.td>
                                            @if ($item->type === 'vente')
                                                @if (
                                                    $item->jours_ecoules > (45 + $j) &&
                                                    $item->jours_ecoules <= (45 + $k)
                                                )
                                                    Oui {{ $item->jours_ecoules }}
                                                @endif
                                            @else
                                                @if (
                                                    $item->jours_ecoules > (30 + $j) &&
                                                    $item->jours_ecoules <= (30 + $k)
                                                )
                                                    Oui {{ $item->jours_ecoules }}
                                                @endif
                                            @endif
                                        </x-table.td>
                                    @endfor
                                    <x-table.td>
                                        @if ($item->type === 'vente')
                                            @if ($item->jours_ecoules > (45 + 28))
                                                Oui {{ $item->jours_ecoules }}
                                            @endif
                                        @else
                                            @if ($item->jours_ecoules > (30 + 28))
                                                Oui {{ $item->jours_ecoules }}
                                            @endif
                                        @endif
                                    </x-table.td>
                                </tr>
                            @endforeach
                        </x-table.table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
