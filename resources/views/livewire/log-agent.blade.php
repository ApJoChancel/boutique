<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Pointeuse par agent') }}
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
                        <x-label for="date_from" :value="__('Date debut')" />
                        <x-input wire:model.live="date_from" id="date_from" type="date" />
                    </div>
                    <div>
                        <x-label for="date_to" :value="__('Date fin')" />
                        <x-input wire:model.live="date_to" id="date_to" type="date" />
                    </div>
                    {{-- <div class="mt-4">
                        <x-label for="boutique_id" :value="__('Boutique')" />
                        <x-forms.select wire:model.lazy="boutique_id" id="boutique_id" class="block mt-1 w-full">
                            <option value="0">Toutes les boutiques</option>
                            @foreach ($boutiques as $boutique)
                                <option value="{{ $boutique->id }}" wire:key="{{ $boutique->id }}">
                                    {{ $boutique->designation }}
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div> --}}
                    <div class="mt-4">
                        <x-label for="user_id" :value="__('Utilisateur')" />
                        <x-forms.select wire:model.lazy="user_id" id="user_id" class="block mt-1 w-full">
                            <option value="0">Tous</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" wire:key="{{ $user->id }}">
                                    {{ "{$user->nom} {$user->prenom}" }}
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>
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
                            @foreach ($items as $date)
                                @foreach ($date['logs'] as $item)
                                    @php
                                        $retard = strtotime($parametre->heure) < strtotime($item->connexion);
                                    @endphp
                                    <tr class="border-2" @if ($retard) style="color: red;" @endif>
                                        @if ($date['logs'][0] == $item)
                                            <x-table.td
                                                rowspan="{{ $date['count'] }}"
                                            >
                                                {{ formatDateLong($item->day) }}
                                            </x-table.td>
                                        @endif
                                        <x-table.td>{{ $item->login }}</x-table.td>
                                        <x-table.td>{{ $item->utilisateur }}</x-table.td>
                                        <x-table.td>{{ date('H:i', strtotime($item->connexion)) }}</x-table.td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </x-table.table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
