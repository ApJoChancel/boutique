<div>
    {{-- <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    
                </label>
                <input wire:model.live="year" id="year" type="year" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div style="width: 50%;margin: 20px">
            <h2>Toutes les boutiques</h2>
            <div>
                <canvas id="cour"></canvas>
                <script>
                    const labels = <?= json_encode($labels) ?>;
                    const montantRecu = <?= json_encode($montantRecu) ?>;
                    const reduction = <?= json_encode($reduction) ?>;
                    const reste = <?= json_encode($reste) ?>;
                    const total = <?= json_encode($total) ?>;
                    const ctx = document.getElementById('cour').getContext('2d');
                    const cour = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Montant Reçu',
                                    data: montantRecu,
                                    backgroundColor: 'rgb(173, 255, 47)',
                                    fill: false,
                                },
                                {
                                    label: 'Réduction',
                                    data: reduction,
                                    backgroundColor: 'rgb(255, 105, 97)',
                                    fill: false,
                                },
                                {
                                    label: 'Reste',
                                    data: reste,
                                    backgroundColor: 'rgb(255, 255, 153)',
                                    fill: false,
                                },
                                {
                                    label: 'CA',
                                    data: total,
                                    backgroundColor: 'rgb(135, 206, 235)',
                                    fill: false,
                                },
                            ],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });
                </script>
            </div>
        </div>
    </div> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Caisse') }}
                    </h2>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="year" :value="__('Année')" />
                        <x-input wire:model.live="year" id="year" type="year" />
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    {{-- <div class="overflow-x-auto">
                        <h2>Toutes les boutiques</h2>
                        <div style="margin: 20px">
                            <div>
                                <canvas id="cour"></canvas>
                                <script>
                                    const labels = <?= json_encode($labels) ?>;
                                    const montantRecu = <?= json_encode($montantRecu) ?>;
                                    const reduction = <?= json_encode($reduction) ?>;
                                    const reste = <?= json_encode($reste) ?>;
                                    const total = <?= json_encode($total) ?>;
                                    const ctx = document.getElementById('cour').getContext('2d');
                                    const cour = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: labels,
                                            datasets: [
                                                {
                                                    label: 'Montant Reçu',
                                                    data: montantRecu,
                                                    backgroundColor: 'rgb(173, 255, 47)',
                                                    fill: false,
                                                },
                                                {
                                                    label: 'Réduction',
                                                    data: reduction,
                                                    backgroundColor: 'rgb(255, 105, 97)',
                                                    fill: false,
                                                },
                                                {
                                                    label: 'Reste',
                                                    data: reste,
                                                    backgroundColor: 'rgb(255, 255, 153)',
                                                    fill: false,
                                                },
                                                {
                                                    label: 'CA',
                                                    data: total,
                                                    backgroundColor: 'rgb(135, 206, 235)',
                                                    fill: false,
                                                },
                                            ],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                },
                                            },
                                        },
                                    });
                                </script>
                            </div>
                        </div>
                    </div> --}}
                    <div style="width: 100%;margin: 20px">
                        <div>
                            <div id="cai" style="height: 500px"></div>
                            <script>
                                lineChart(
                                    'cai',
                                    <?= json_encode($totaux) ?>
                                    ,<?= json_encode($recus) ?>
                                    ,<?= json_encode($reductions) ?>
                                    ,<?= json_encode($restes) ?>
                                    ,<?= json_encode($legend) ?>
                                    ,<?= json_encode($axis) ?>
                                    ,<?= json_encode($recus) ?>
                                );
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>