<div>
    <div>
        <form wire:submit="save">
            <div>
                <label for="libelle">Libellé</label>
                <input wire:model.live="libelle" id="libelle" type="text">
                @error('libelle') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <input type="submit" value="{{ $this->textSubmit }}">
                <input wire:click='resetValues' type="reset" value="Annuler">
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $item)
                <tr
                    wire:click='editItem({{ $item->id }})'
                    wire:dblclick='deleteItem({{ $item->id }})'
                >
                    <td>{{ $item->libelle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- deleteModal -->
    <div wire:ignore.self class="modal fade" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Confirmer la suppression</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Suppression de &lt; {{ $this->libelle }} &gt;</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" wire:click="deleteConfirmed({{ $this->delete_id }})">
                        Valider
                    </button>
                    <button class="btn btn-primary btn-sm" wire:click="deleteCancelled" data-bs-dismiss="modal">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
