<div>
    <form wire:submit="save" class="form-horizontal w-3/4 mx-auto">
        <div class="flex flex-col mt-4">
            <input wire:model.live="login" type="text" placeholder="Login" class="flex-grow h-8 px-2 border rounded border-grey-400">
            @error('login') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
        </div>
        <div class="flex flex-col mt-4">
            <input wire:model="password" type="password" placeholder="Password" class="flex-grow h-8 px-2 rounded border border-grey-400">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col mt-8">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded">
                {{ $this->textSubmit }}
            </button>
        </div>
    </form>
</div>
