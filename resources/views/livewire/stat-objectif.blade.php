<div>
    <div class="container">
        @for ($i = 0; $i < count($items); $i++)
        <div style="width: 50%;margin: 20px">
            <?php $id = "graph" . ($i+1); ?>
            <h2>{{ $boutiques[$i] }}</h2>
            <div>
                <canvas id="{{ $id }}"></canvas>
                <script>
                    graphique('<?= $id ?>', <?= json_encode($labels) ?>, <?= json_encode($items[$i]) ?>);
                </script>
            </div>
        </div>
        @endfor
        <h2>Toutes les boutiques</h2>
        <div>
            <canvas id="global"></canvas>
            <script>
                graphique('global', <?= json_encode($labels) ?>, <?= json_encode($global) ?>);
            </script>
        </div>

    </div>
</div>