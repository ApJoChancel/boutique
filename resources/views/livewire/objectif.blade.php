<div>
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Objectif mensuel') }}
                        </h2>
                        @if (session()->has('status'))
                            <div class="fixed bottom-0 right-0 m-4" id="toast">
                                <div class="bg-blue-500 border-l-4 border-blue-700 py-2 px-3 rounded-lg shadow-md">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <span class="text-white">{{ session('status') }}</span>
                                        </div>
                                        <button class="text-white ml-5" wire:click="closeToast">&times;</button>
                                    </div>
                                </div>
                            </div>
                        @endif 
                    </div>
                    <div class="flex items-center justify-center flex-col">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form wire:submit="save">
                                <div>
                                    <x-label for="montant" :value="__('Objectif mensuel par défaut')" />
                                    <x-input wire:model.live="montant" id="montant" type="text" class="block mt-1 w-full" />
                                    @error('montant') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                                </div>
                    
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ $this->textSubmit }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
