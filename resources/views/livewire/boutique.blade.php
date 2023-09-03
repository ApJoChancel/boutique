<div>
    <div>
        <form wire:submit="save">
            <div>
                <label for="designation">Désignation</label>
                <input wire:model.live="designation" id="designation" type="text">
                @error('designation') <span>{{ $message }}</span> @enderror
            </div>
            @if(!$this->edit_id)
                <div>
                    <label for="user">Manager</label>
                    <select wire:model="user_id" name="user_id" id="user">
                        <option>Choisir un manager</option>
                        @foreach ($users as $item)
                            <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->login }}</option>
                        @endforeach
                    </select>
                    @error('user') <span>{{ $message }}</span> @enderror
                </div>
            @endif

            <div>
                <input type="submit" value="{{ $this->textSubmit }}">
                <input wire:click='resetValues' type="reset" value="Annuler">
            </div>
        </form>
        @if ($this->edit_id)
            <button wire:click='changeManager({{ $this->edit_id }})'>Changer le manager</button>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Boutique</th>
                <th>Manager</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($boutiques as $item)
                <tr
                    wire:click='editItem({{ $item->id }})'
                    wire:dblclick='deleteItem({{ $item->id }})'
                >
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->manager?->login }}</td>
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
                    <p>Suppression de &lt; {{ $this->designation }} &gt;</p>
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

    <!-- changeModal -->
    <div wire:ignore.self class="modal fade" id="changeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Changer le manager</h5>
                    <button class="btn-close" wire:click="deleteCancelled()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="changeManagerData">
                        <div>
                            <label>Manager actuel : {{ $this->designation }}</label>
                        </div>
                        <div>
                            <label for="user">Nouveau manager</label>
                            <select wire:model="user_id" name="user_id" id="user">
                                <option>Choisir un manager</option>
                                @foreach ($users as $item)
                                    <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->login }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div>
                            <input type="submit" value="{{ $this->textSubmit }}">
                            <input wire:click='resetValues' type="reset" value="Annuler">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
