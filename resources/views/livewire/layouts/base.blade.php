{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    @livewireStyles
    <script>
        function pieGraphique(idcanvas, labels, datas){
            const pieCanvas = document.getElementById(idcanvas);
            const pieChart = new Chart(pieCanvas, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [{
                        labels: labels,
                        data: datas,
                        backgroundColor: [
                            'rgb(135, 206, 235)',
                            'rgb(255, 105, 97)',
                            'rgb(173, 255, 47)',
                            'rgb(255, 255, 153)'
                        ],
                        hoverOffset: 40,
                        borderWidth: 1
                    }],
                },
            });
        }

        function barGraphique(idcanvas, labels, datas){
            const barCanvas = document.getElementById(idcanvas);
            const barChart = new Chart(barCanvas, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        labels: labels,
                        data: datas,
                        backgroundColor: [
                            'rgb(135, 206, 235)',
                            'rgb(255, 105, 97)',
                            'rgb(173, 255, 47)',
                            'rgb(255, 255, 153)'
                        ],
                    }
                ]
                },
            });
        }
    </script>
</head>
<body>
    <div class="flex flex-col h-screen bg-gray-100">

        <!-- Barra de navegación superior -->
        <div class="bg-white text-white shadow w-full p-2 flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center"> <!-- Mostrado en todos los dispositivos -->
                    <img src="/nuptial.jpg" alt="Logo" style="width: 150px">
                    <h2 class="font-bold text-xl">CORNALD Nuptial</h2>
                </div>
                <div class="md:hidden flex items-center"> <!-- Se muestra solo en dispositivos pequeños -->
                    <button id="menuBtn">
                        <i class="fas fa-bars text-gray-500 text-lg"></i> <!-- Ícono de menú -->
                    </button>
                </div>
            </div>
    
            <!-- Ícono de Notificación y Perfil -->
            <div class="space-x-5">
                <button>
                    <i class="fas fa-bell text-gray-500 text-lg"></i>
                </button>
                <!-- Botón de Perfil -->
                <button>
                    <i class="fas fa-user text-gray-500 text-lg"></i>
                </button>
            </div>
        </div>
    
        <!-- Contenido principal -->
        <div class="flex-1 flex flex-wrap">
            <!-- Barra lateral de navegación (oculta en dispositivos pequeños) -->
            <div class="p-2 bg-white w-full md:w-60 flex flex-col md:flex hidden" id="sideNav">
                <nav>
                    <a href="{{ route('stat_objectif') }}" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                        <i class="fas fa-home mr-2"></i>Tableau de bord
                    </a>

                    <div class="relative">
                        <a href="#" id="groupBoutique" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                            <i class="fas fa-file-alt mr-2"></i>Boutiques & utilisateurs
                        </a>

                        <div id="groupBoutiqueContent" class="absolute left-14 top-0 hidden mt-2 space-y-2 bg-white border border-gray-200 w-40">
                            <a href="{{ route('zone') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Zones</a>
                            <a href="{{ route('user') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Utilisateurs</a>
                            <a href="{{ route('boutique') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Boutiques</a>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="#" id="groupArticle" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                            <i class="fas fa-file-alt mr-2"></i>Articles
                        </a>

                        <div id="groupArticleContent" class="absolute left-14 top-0 hidden mt-2 space-y-2 bg-white border border-gray-200 w-40">
                            <a href="{{ route('carac') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Caractéristiques</a>
                            <a href="{{ route('categorie') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Catégories</a>
                            <a href="{{ route('article') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Articles</a>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="#" id="groupVente" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                            <i class="fas fa-file-alt mr-2"></i>Ventes
                        </a>

                        <div id="groupVenteContent" class="absolute left-14 top-0 hidden mt-2 space-y-2 bg-white border border-gray-200 w-40">
                            <a href="{{ route('visite') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visites</a>
                            <a href="{{ route('vente') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ventes</a>
                            <a href="{{ route('rec') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Recouvrements</a>
                        </div>
                    </div>
                    <a href="{{ route('objectif') }}" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                        <i class="fas fa-home mr-2"></i>Objectif mensuel
                    </a>
                    <div class="relative">
                        <a href="#" id="groupStat" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
                            <i class="fas fa-file-alt mr-2"></i>Statistiques
                        </a>

                        <div id="groupStatContent" class="absolute left-14 top-0 hidden mt-2 space-y-2 bg-white border border-gray-200 w-40">
                            <a href="{{ route('log') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pointeuse</a>
                            <a href="{{ route('stat_ca') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">CA</a>
                            <a href="{{ route('stat_caisse') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Caisse</a>
                            <a href="{{ route('stat_decla') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déclassement</a>
                        </div>
                    </div>
                </nav>

                <!-- Ítem de Cerrar Sesión -->
                <a href="{{ route('logout') }}" class="text-gray-500 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white mt-auto">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                </a>

                <!-- Señalador de ubicación -->
                <div class="bg-gradient-to-r from-cyan-300 to-cyan-500 h-px mt-2"></div>

                <!-- Copyright al final de la navegación lateral -->
                <p class="mb-1 px-5 py-3 text-left text-xs text-cyan-500">Copyright WCSLAT@2023</p>
            </div>

            <!-- Área de contenido principal -->
            <div class="flex-1 p-4 w-full md:w-1/2">
                <!-- Campo de búsqueda -->
                <div class="relative max-w-md w-full">
                    <div class="absolute top-1 left-2 inline-flex items-center p-2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input placeholder="Rechercher..." class="w-full h-10 pl-10 pr-4 py-1 text-base placeholder-gray-500 border rounded-full focus:shadow-outline" type="search">
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-toast', event => {
            $('#toast').modal('hide');
        });

        window.addEventListener('close-toast-after-3-seconds', event => {
            setTimeout(function () {
                document.getElementById('toast').style.display = 'none';
            }, 3000);
        });
    </script>
    <script>
        document.getElementById('groupBoutique').addEventListener('click', function() {
            document.getElementById('groupBoutiqueContent').classList.toggle('hidden');
        });
        document.getElementById('groupArticle').addEventListener('click', function() {
            document.getElementById('groupArticleContent').classList.toggle('hidden');
        });
        document.getElementById('groupVente').addEventListener('click', function() {
            document.getElementById('groupVenteContent').classList.toggle('hidden');
        });
        document.getElementById('groupStat').addEventListener('click', function() {
            document.getElementById('groupStatContent').classList.toggle('hidden');
        });
    </script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @livewireScripts
</body>
</html> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title ?? 'Page Title' }}</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        @vite('resources/css/app.css')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        @livewireStyles
        <script>
            function pieGraphique(idcanvas, labels, datas){
                const pieCanvas = document.getElementById(idcanvas);
                const pieChart = new Chart(pieCanvas, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            labels: labels,
                            data: datas,
                            backgroundColor: [
                                'rgb(135, 206, 235)',
                                'rgb(255, 105, 97)',
                                'rgb(173, 255, 47)',
                                'rgb(255, 255, 153)'
                            ],
                            hoverOffset: 40,
                            borderWidth: 1
                        }],
                    },
                });
            }

            function barGraphique(idcanvas, labels, datas){
                const barCanvas = document.getElementById(idcanvas);
                const barChart = new Chart(barCanvas, {
                    type: "bar",
                    data: {
                        labels: labels,
                        datasets: [{
                            labels: labels,
                            data: datas,
                            backgroundColor: [
                                'rgb(135, 206, 235)',
                                'rgb(255, 105, 97)',
                                'rgb(173, 255, 47)',
                                'rgb(255, 255, 153)'
                            ],
                        }
                    ]
                    },
                });
            }
        </script>
    </head>
    <body>
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                  <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                      <span class="sr-only">Open sidebar</span>
                      <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                         <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                      </svg>
                   </button>
                    <a href="" class="flex ml-2 md:mr-24">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                      <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                          <span class="sr-only">Open user menu</span>
                          <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                      </div>
                      <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                          <p class="text-sm text-gray-900 dark:text-white" role="none">
                            {{ Auth::user()->nom }}
                          </p>
                          <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                            {{ Auth::user()->email }}
                          </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
        
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        🔙{{ __('Déconnexion') }}
                                    </x-dropdown-link>
                                </form>
                            </li>
                        </ul>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </nav>

        <div class="bg-gray-100" style="min-height: 10vh">
            @include('livewire.layouts.navigation')
        </div>
            <!-- Page Content -->
            <main class="p-4 sm:ml-64">
                {{ $slot }}
            </main>

            <script>
                window.addEventListener('close-toast', event => {
                    $('#toast').modal('hide');
                });
        
                window.addEventListener('close-toast-after-3-seconds', event => {
                    setTimeout(function () {
                        document.getElementById('toast').style.display = 'none';
                    }, 3000);
                });
            </script>
            
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            @stack('scripts')
            @livewireScripts
    </body> 
</html>
