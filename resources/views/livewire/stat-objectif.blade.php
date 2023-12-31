<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Tableau de bord') }}
                    </h2>
                </div>
            </div>
        </div>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        @for ($i = 0; $i < count($items); $i++)
                            <div style="width: 80%;margin: 20px">
                                <?php $id = "graph" . ($i+1); ?>
                                <h2>{{ $boutiques[$i] }}</h2>
                                <div>
                                    <div id="{{ $id }}" style="height: 500px"></div>
                                    <script>
                                        barChart('<?= $id ?>', <?= json_encode($labels) ?>, <?= json_encode($items[$i]) ?>);
                                    </script>
                                </div>
                            </div>
                        @endfor
                    </div>
                    @if (!$is_com)
                        <div class="overflow-x-auto">
                            <h2>Toutes les boutiques</h2>
                            <div>
                                <div id="global" style="height: 500px"></div>
                                <script>
                                    barChart('global', <?= json_encode($labels) ?>, <?= json_encode($global) ?>);
                                </script>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>