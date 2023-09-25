<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
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

    </div>
</div>