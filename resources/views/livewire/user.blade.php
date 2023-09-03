<div>
    <div>
        <form wire:submit="register">
            <div>
                <label for="login">Login</label>
                <input wire:model.live="login" id="login" type="text">
                @error('login') <span>{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="role">Role</label>
                <select wire:model="role" name="role" id="role">
                    @foreach ($roles as $item)
                        <option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->libelle }}</option>
                    @endforeach
                </select>
                @error('role') <span>{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="submit" value="{{ 'Valider' }}">
                <button>Réinitialiser le mot de passe</button>
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
                <tr>
                    <td>{{ $item->login }}</td>
                    <td>{{ $item->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
