<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Les ventes en cours</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Client
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Type
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Montant vente
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Reste à percevoir
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Téléphone
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Dans les temps
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        1 semaine
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        2 semaines
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        3 semaines
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        4 semaines
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Plus
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventes as $item)
                    <tr class="hover:bg-grey-lighter">
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ "{$item->nom} {$item->prenom}" }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->type }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->montant_vente }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->reste }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->telephone }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            @if ($item->type === 'vente')
                                @if ($item->jours_ecoules < 45)
                                    Oui {{ $item->jours_ecoules }}
                                @endif
                            @else
                                @if ($item->jours_ecoules < 30)
                                    Oui {{ $item->jours_ecoules }}
                                @endif
                            @endif
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
                            @if ($item->type === 'vente')
                                @if ($item->jours_ecoules > (45 + 28))
                                    Oui {{ $item->jours_ecoules }}
                                @endif
                            @else
                                @if ($item->jours_ecoules > (30 + 28))
                                    Oui {{ $item->jours_ecoules }}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
