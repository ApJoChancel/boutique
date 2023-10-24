<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Visites conclues') }}
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
                            <div style="width: 50%;margin: 20px">
                                <div>
                                    <canvas id="{{ $key }}"></canvas>
                                    @if (in_array($data['titre'], ["Profil du visiteur", "Lieu de résidence"]))
                                        <script>
                                            barGraphique('{{ $key }}', <?= json_encode($data['label']) ?>, <?= json_encode($data['totaux']) ?>);
                                        </script>
                                    @else
                                        <script>
                                            pieGraphique('{{ $key }}', <?= json_encode($data['label']) ?>, <?= json_encode($data['totaux']) ?>);
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