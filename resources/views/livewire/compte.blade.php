<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mon compte') }}
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

                <div class="p-6 bg-white border-b border-gray-200">
                    <form wire:submit="changePassword">
                        {{-- <div class="relative flex mb-3">
                            <x-label for="ancien" :value="__('Ancien')" />
                            <x-input wire:model="ancien" id="ancien" type="password" class="block mt-1 w-full" />
                            <button class="bg-red-500 py-2 px-4 rounded-r absolute right-0 top-0 bottom-0">Go</button>
                            @error('ancien') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                        </div> --}}
                        <div class="relative flex mb-3">
                            <x-label for="ancien" :value="__('Ancien')" />
                            <x-input wire:model="ancien" id="ancien" type="password" class="block mt-1 w-full" />
                            @error('ancien') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mt-4">
                            <x-label for="nouveau" :value="__('Nouveau')" />
                            <x-input wire:model="nouveau" id="nouveau" type="password" class="block mt-1 w-full" />
                            @error('nouveau') <p class="font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mt-4">
                            <x-label for="confirm" :value="__('Confirmer le nouveau')" />
                            <x-input wire:model="confirm" id="confirm" type="password" class="block mt-1 w-full" />
                        </div>
            
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Changer le mot de passe') }}
                            </x-button>
                            <button  wire:click='resetValues' type="reset" class="py-2 px-4 bg-transparent text-purple-600 font-semibold border border-purple-600 rounded hover:bg-purple-600 hover:text-white hover:border-transparent transition ease-in duration-200 transform hover:-translate-y-1 active:translate-y-0">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>