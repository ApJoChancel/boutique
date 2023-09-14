<div>
    <table>
        <thead>
            <tr>
                <th>Date de vente</th>
                <th>Client</th>
                <th>Montant vente</th>
                <th>Montant reçu</th>
                <th>Reste à percevoir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventes as $item)
                <tr
                    wire:click='infoItem({{ $item->vente_id }})'
                    wire:dblclick='paiementItem({{ $item->vente_id }})'
                >
                    <td>{{ $item->date_vente }}</td>
                    <td>{{ $item->client }}</td>
                    <td>{{ $item->montant_vente }}</td>
                    <td>{{ $item->montant_recu }}</td>
                    <td>{{ $item->reste }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
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