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
                            {{ $item->client }}
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- infoModal -->
    <div wire:ignore.self class="modal fade" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Détails de la vente</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($vente)
                    <div class="modal-body">
                        <p>Vente N° 00{{ $vente->id }}</p>
                        <p>Articles</p>
                        <div>
                            <table>
                                <tbody>
                                    @foreach ($vente->ligneVentes as $item)
                                        <tr>
                                            <td>{{ $item->article->libelle }}</td>
                                            <td>{{ $item->caracteristiques }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p>Paiements</p>
                        <div>
                            <table>
                                <tbody>
                                    @foreach ($vente->paiements as $item)
                                        <tr>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->montant }}</td>
                                            <td>{{ $item->reduction }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" wire:click="paiementItem({{ $vente?->id }})" data-bs-dismiss="modal">
                        Nouveau paiement
                    </button>
                    <button class="btn btn-primary btn-sm" wire:click="deleteCancelled" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- paieModal -->
    <div wire:ignore.self class="modal fade" id="paieModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Détails de la vente</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="paiementItemData({{ $vente?->id }})">
                        <div>
                            <label for="montant">Montant</label>
                            <input wire:model.live="montant" id="montant" type="text">
                            @error('montant') <span>{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="reduction">Réduction</label>
                            <input wire:model.live="reduction" id="reduction" type="text">
                            @error('reduction') <span>{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="submit" value="{{ $this->textSubmit }}">
                            <input wire:click='resetValues' type="reset" value="Annuler">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" wire:click="deleteCancelled" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>