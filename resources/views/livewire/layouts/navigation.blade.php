{{-- <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <x-nav-link :href="route('stat_objectif')">
                🏫{{ __('Tableau de bord') }}
            </x-nav-link>
            <x-nav-link :href="route('zone')">
                👥{{ __('Zones') }}
            </x-nav-link>
            <x-nav-link :href="route('user')">
                🗂️{{ __('Utilisateurs') }}
            </x-nav-link>
            <x-nav-link :href="route('boutique')">
                🤵{{ __('Boutiques') }}
            </x-nav-link>
            <x-nav-link :href="route('carac')">
                📚{{ __('Caractéristiques') }}
            </x-nav-link>
            <x-nav-link :href="route('categorie')">
                📚{{ __('Catégories') }}
            </x-nav-link>
            <x-nav-link :href="route('article')">
                📚{{ __('Articles') }}
            </x-nav-link>
            <x-nav-link :href="route('visite')">
                📚{{ __('Visites') }}
            </x-nav-link>
            <x-nav-link :href="route('vente')">
                📚{{ __('Ventes') }}
            </x-nav-link>
            <x-nav-link :href="route('rec')">
                📚{{ __('Recouvrements') }}
            </x-nav-link>
            <x-nav-link :href="route('log')">
                📚{{ __('Pointeuse') }}
            </x-nav-link>
            <x-nav-link :href="route('stat_ca')">
                📚{{ __('CA') }}
            </x-nav-link>
            <x-nav-link :href="route('stat_caisse')">
                📚{{ __('Caisse') }}
            </x-nav-link>
            <x-nav-link :href="route('stat_decla')">
                📚{{ __('Déclassement') }}
            </x-nav-link>
        </ul>
    </div>
</aside> --}}

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('stat_objectif') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>🏢 Administration</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <x-nav-link :href="route('zone')" :active="request()->routeIs('zone')">
                                    {{ __('🗺️ Zones') }}
                                </x-nav-link>
                                <x-nav-link :href="route('user')" :active="request()->routeIs('user')">
                                    {{ __('👥 Utilisateurs') }}
                                </x-nav-link>
                                <x-nav-link :href="route('boutique')" :active="request()->routeIs('boutique')">
                                    {{ __('🏪 Boutiques') }}
                                </x-nav-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>👗 Produits</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <x-nav-link :href="route('carac')" :active="request()->routeIs('carac')">
                                    {{ __('🧩 Caractéristiques') }}
                                </x-nav-link>
                                <x-nav-link :href="route('categorie')" :active="request()->routeIs('categorie')">
                                    {{ __('📚 Catégories') }}
                                </x-nav-link>
                                {{-- <x-nav-link :href="route('article')" :active="request()->routeIs('article')">
                                    {{ __('👢 Articles') }}
                                </x-nav-link> --}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>💰 Exploitation</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <x-nav-link :href="route('visite')" :active="request()->routeIs('visite')">
                                    {{ __('🏃 Visites') }}
                                </x-nav-link>
                                <x-nav-link :href="route('vente')" :active="request()->routeIs('vente')">
                                    {{ __('💯 Ventes') }}
                                </x-nav-link>
                                <x-nav-link :href="route('rec')" :active="request()->routeIs('rec')">
                                    {{ __('⚠️ Recouvrements') }}
                                </x-nav-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>📊 Statistiques</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <x-nav-link :href="route('log')" :active="request()->routeIs('log')">
                                    {{ __('⏳ Pointeuse') }}
                                </x-nav-link>
                                <x-nav-link :href="route('stat_ca')" :active="request()->routeIs('stat_ca')">
                                    {{ __('📝 CA') }}
                                </x-nav-link>
                                <x-nav-link :href="route('stat_caisse')" :active="request()->routeIs('stat_caisse')">
                                    {{ __('💶 Caisse') }}
                                </x-nav-link>
                                <x-nav-link :href="route('stat_decla')" :active="request()->routeIs('stat_decla')">
                                    {{ __('📉 Déclassement') }}
                                </x-nav-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-nav-link :href="route('parametre')" :active="request()->routeIs('parametre')">
                            {{ __('⚙️ Paramètres') }}
                        </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nom .' ' .Auth::user()->prenom }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-nav-link :href="route('compte')" :active="request()->routeIs('compte')">
                            {{ __('♟️ Mon compte') }}
                        </x-nav-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('🚪 Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <div class="">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>🏢 Administration</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link :href="route('zone')" :active="request()->routeIs('zone')">
                            {{ __('🗺️ Zones') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('user')" :active="request()->routeIs('user')">
                            {{ __('👥 Utilisateurs') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('boutique')" :active="request()->routeIs('boutique')">
                            {{ __('🏪 Boutiques') }}
                        </x-responsive-nav-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>👗 Produits</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link :href="route('carac')" :active="request()->routeIs('carac')">
                            {{ __('🧩 Caractéristiques') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('categorie')" :active="request()->routeIs('categorie')">
                            {{ __('📚 Catégories') }}
                        </x-responsive-nav-link>
                        {{-- <x-responsive-nav-link :href="route('article')" :active="request()->routeIs('article')">
                            {{ __('👢 Articles') }}
                        </x-responsive-nav-link> --}}
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>💰 Exploitation</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link :href="route('visite')" :active="request()->routeIs('visite')">
                            {{ __('🏃 Visites') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('vente')" :active="request()->routeIs('vente')">
                            {{ __('💯 Ventes') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('rec')" :active="request()->routeIs('rec')">
                            {{ __('⚠️ Recouvrements') }}
                        </x-responsive-nav-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>📊 Statistiques</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link :href="route('log')" :active="request()->routeIs('log')">
                            {{ __('⏳ Pointeuse') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('stat_ca')" :active="request()->routeIs('stat_ca')">
                            {{ __('📝 CA') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('stat_caisse')" :active="request()->routeIs('stat_caisse')">
                            {{ __('💶 Caisse') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('stat_decla')" :active="request()->routeIs('stat_decla')">
                            {{ __('📉 Déclassement') }}
                        </x-responsive-nav-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="">
                <x-responsive-nav-link :href="route('parametre')" :active="request()->routeIs('parametre')">
                    {{ __('⚙️ Paramètres') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nom .' ' .Auth::user()->prenom }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-responsive-nav-link :href="route('compte')" :active="request()->routeIs('compte')">
                            {{ __('♟️ Mon compte') }}
                        </x-responsive-nav-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('🚪 Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>