<div>
    <form wire:submit="save" class="form-horizontal w-3/4 mx-auto">
        <div class="flex flex-col">
            <input wire:model.live="login" type="text" placeholder="Login" class="flex-grow h-8 px-2 border rounded border-grey-400">
            @error('login') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
        </div>
        <div class="flex flex-col mt-4">
            <input wire:model.live="password" type="{{ ($voir_mdp) ? 'text' : 'password' }}" placeholder="Password" class="flex-grow h-8 px-2 rounded border border-grey-400">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>
        <div class="mt-4">
            <label class="inline-flex items-center mr-4 mb-2">
                <input wire:model.live='voir_mdp' type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Afficher mot de passe</span>
            </label>
        </div>
        <div class="flex flex-col mt-4">
            <input wire:model='latitude' id="latitude" style="font-size: 1px">
            <input wire:model='longitude' id="longitude" style="font-size: 1px">
        </div>
        
        <div class="flex flex-col mt-8" x-on:click="$wire.set('longitude', document.getElementById('longitude').value)">
            <button x-on:click="$wire.set('latitude', document.getElementById('latitude').value)" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded">
                {{ $this->textSubmit }} 
            </button>
        </div>
    </form>
</div>
