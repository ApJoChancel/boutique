<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')

    @livewireStyles
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
                    <a href="#" class="block text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white">
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
                            <a href="{{ route('vente') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ventes</a>
                            <a href="{{ route('rec') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Recouvrements</a>
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
        window.addEventListener('close-modal', event => {
            $('#confirmModal').modal('hide');
            $('#changeModal').modal('hide');
            $('#infoModal').modal('hide');
            $('#paieModal').modal('hide');
        });

        window.addEventListener('show-confirm', event => {
            $('#confirmModal').modal('show')
        });
        window.addEventListener('show-info', event => {
            $('#infoModal').modal('show')
        });
        window.addEventListener('show-paie', event => {
            $('#paieModal').modal('show')
        });
        window.addEventListener('show-change', event => {
            $('#changeModal').modal('show')
        });
    </script>
    <script>
        document.getElementById('groupBoutique').addEventListener('click', function() {
            document.getElementById('groupBoutiqueContent').classList.toggle('hidden');
        });
        document.getElementById('groupArticle').addEventListener('click', function() {
            document.getElementById('groupArticleContent').classList.toggle('hidden');
        });document.getElementById('groupVente').addEventListener('click', function() {
            document.getElementById('groupVenteContent').classList.toggle('hidden');
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @livewireScripts
</body>
</html>