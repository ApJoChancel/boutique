<div>
    <div class="container">
        <canvas id="global"></canvas>
        <script>
            graphique('global', <?= json_encode($labels) ?>, <?= json_encode($datas) ?>);
        </script>
    </div>
</div>

@push('scripts')
    <script>
        function graphique(idcanvas, labels, datas){
            const barCanvas = document.getElementById(idcanvas);
            const barChart = new Chart(barCanvas, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        data: datas,
                        backgroundColor: ['blue', 'red', 'yellow']
                    }]
                },
            });
        }
    </script>
@endpush