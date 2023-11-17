<div>
    {{-- <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="date_from" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Du
                </label>
                <input wire:model.live="date_from" id="date_from" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="date_to" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Au
                </label>
                <input wire:model.live="date_to" id="date_to" type="date" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div style="width: 50%;margin: 20px">
            <h2>Toutes les boutiques</h2>
            <div>
                <canvas id="tab"></canvas>
                <script>
                    barGraphique('tab', <?= json_encode($labels) ?>, <?= json_encode($totaux) ?>);
                </script>
            </div>
        </div>

        <div style="width: 50%;margin: 20px">
            <h2>Toutes les boutiques</h2>
            <div>
                <canvas id="cam"></canvas>
                <script>
                    pieGraphique('cam', <?= json_encode($labels) ?>, <?= json_encode($totaux) ?>);
                </script>
            </div>
        </div>

    </div> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Chiffre d\'affaire') }}
                    </h2>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="date_from" :value="__('Du')" />
                        <x-input wire:model.live="date_from" id="date_from" type="date" />
                    </div>
                    <div>
                        <x-label for="date_to" :value="__('Au')" />
                        <x-input wire:model.live="date_to" id="date_to" type="date" />
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <h2>Toutes les boutiques</h2>
                        {{-- <div style="width: 50%;margin: 20px">
                            <div>
                                <canvas id="cam"></canvas>
                                <script>
                                    pieGraphique('cam', <?= json_encode($labels) ?>, <?= json_encode($totaux) ?>);
                                </script>
                            </div>
                        </div> --}}
                        <div style="width: 100%;margin: 20px">
                            <div>
                                <div id="autr" style="height: 500px"></div>
                                <script>
                                    pieChart('autr', <?= json_encode($labels) ?>, <?= json_encode($autres) ?>);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>