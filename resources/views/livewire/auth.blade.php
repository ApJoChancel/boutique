<div>
    <form wire:submit="save" class="form-horizontal w-3/4 mx-auto">
        <div class="flex flex-col">
            <input wire:model.live="login" type="text" placeholder="Login" class="flex-grow h-8 px-2 border rounded border-grey-400">
            @error('login') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
        </div>
        <div class="flex flex-col mt-4">
            <input wire:model="password" type="{{ ($voir_mdp) ? 'text' : 'password' }}" placeholder="Password" class="flex-grow h-8 px-2 rounded border border-grey-400">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>
        <div class="mt-4">
            <label class="inline-flex items-center mr-4 mb-2">
                <input wire:model.live='voir_mdp' type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Afficher mot de passe</span>
            </label>
        </div>
        <div class="flex flex-col mt-4">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
        </div>
        
        <div id="btnconnexion" class="flex flex-col mt-8">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded">
                {{ $this->textSubmit }}
            </button>
        </div>
    </form>
</div>
