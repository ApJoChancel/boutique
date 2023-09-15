<div>
    {{-- <form wire:submit="changeNoms">
        <h4>Changer le noms</h4>
        <div>
            <label for="noms">Noms et prénoms</label>
            <input wire:model.live="noms" id="noms" type="text">
            @error('noms') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <input type="submit" value="{{ $this->textSubmit }}">
        </div>
    </form> --}}

    {{-- <form wire:submit="pass">
        <h4>Changer le mot de passe</h4>
        <div>
            <label for="ancien">Ancien</label>
            <input wire:model.live="ancien" id="ancien" type="password">
            @error('ancien') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="nouveau">Nouveau</label>
            <input wire:model.live="nouveau" id="nouveau" type="password">
            @error('nouveau') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="confirm">Confirmer le nouveau</label>
            <input wire:model.live="confirm" id="confirm" type="password">
        </div>

        <div>
            <input type="submit" value="{{ $this->textSubmit }}">
        </div>
    </form> --}}
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
</div>
