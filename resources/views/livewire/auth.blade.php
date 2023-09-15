<div>
    <form wire:submit="save">
        <div>
            <label for="email">email</label>
            <input wire:model.live="email" id="email" type="text">
            @error('email') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input wire:model.live="password" id="password" type="password">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <input type="submit" value="{{ $this->textSubmit }}">
        </div>
    </form>
</div>
