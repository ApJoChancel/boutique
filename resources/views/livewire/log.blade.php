<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="date_search" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Date
                </label>
                <input wire:model.live="date_search" id="date_search" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <h2 class="text-gray-500 text-lg font-semibold pb-4">Pointeuse</h2>
        <div class="my-1"></div> <!-- Espacio de separación -->
        <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mb-6"></div> <!-- Línea con gradiente -->
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="text-sm leading-normal">
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Login
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Utilisateur
                    </th>
                    <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-light border-b border-grey-light">
                        Heure
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="hover:bg-grey-lighter">
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ $item->login }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ "{$item->nom} {$item->prenom}" }}
                        </td>
                        <td class="py-2 px-4 border-b border-grey-light">
                            {{ date('H:i:s', strtotime($item->connexion)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
