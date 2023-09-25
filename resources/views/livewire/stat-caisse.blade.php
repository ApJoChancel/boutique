<div>
    <div class="mt-8 bg-white p-4 shadow rounded-lg">
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="year" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                    Année
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
                    const ctx = document.getElementById('cour').getContext('2d');
                    const cour = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Montant Reçu',
                                    data: montantRecu,
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    fill: false,
                                },
                                {
                                    label: 'Réduction',
                                    data: reduction,
                                    backgroundColor: 'rgb(54, 162, 235)',
                                    fill: false,
                                },
                                {
                                    label: 'Reste',
                                    data: reste,
                                    backgroundColor: 'rgb(75, 192, 192)',
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
    </div>
</div>