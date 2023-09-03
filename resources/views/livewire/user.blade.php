<div>
    <div>
        <form wire:submit="register">
            <div>
                <label for="login">Login</label>
                <input wire:model.live="login" id="login" type="text">
                @error('login') <span>{{ $message }}</span> @enderror
            </div>
            @empty($this->edit_id)
                <div>
                    <label for="role">Role</label>
                    <select wire:model="role_id" name="role_id" id="role">
                        <option>Choisir un rôle</option>
                        @foreach ($roles as $item)
                            <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                        @endforeach
                    </select>
                    @error('role') <span>{{ $message }}</span> @enderror
                </div>
            @endempty

            <div>
                <input type="submit" value="{{ $this->textSubmit }}">
                <input wire:click='resetValues' type="reset" value="Annuler">
                @if ($this->edit_id)
                    <button wire:click='resetPassword({{ $this->edit_id }})'>Réinitialiser le mot de passe</button>
                @endif
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Login</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr
                    wire:click='editItem({{ $item->id }})'
                    wire:dblclick='deleteItem({{ $item->id }})'
                >
                    <td>{{ $item->login }}</td>
                    <td>{{ $item->role->libelle }}</td>
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
                    <p>Suppression de &lt; {{ $this->login }} &gt;</p>
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
