<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Visites conclues') }}
                    </h2>
                    <h2 style="text-align: right" class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Visites : {{ formatNombre($total) }} -
                        Conclues : {{ formatNombre($total_conclue) }}
                    </h2>
                </div>
            </div>
        </div>

        @foreach ($datas as $key => $data)
            <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
                <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <h2>{{ $data['titre'] }}</h2>
                            <div style="width: 100%;margin: 20px">
                                <div>
                                    <div id="{{ $key }}" style="height: 500px"></div>

                                    @if (in_array($data['titre'], ["Profil du visiteur", "Lieu de résidence", "Tranche d'âge"]))
                                        <script>
                                            barChart('{{ $key }}', <?= json_encode($data['label']) ?>, <?= json_encode($data['totaux']) ?>);
                                        </script>
                                    @else
                                        <script>
                                            pieChart('{{ $key }}', <?= json_encode($data['label']) ?>, <?= json_encode($data['totaux']) ?>);
                                        </script>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>
</div>