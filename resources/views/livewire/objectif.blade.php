<div>
    @if (session()->has('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
    <form wire:submit="save">
        <div class="mt-8 bg-white p-4 shadow rounded-lg">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="montant" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                        Objectif mensuel par défaut
                    </label>
                    <input wire:model.live="montant" id="montant" type="text" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                    @error('montant') <p class="text-grey-dark text-xs italic">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <button type="submit" class="py-2 px-4 bg-transparent text-green-600 font-semibold border border-green-600 rounded hover:bg-green-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                    {{ $this->textSubmit }}
                </button>
            </div>
        </div>
    </form>
</div>
