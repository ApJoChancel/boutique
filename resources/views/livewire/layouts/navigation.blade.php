<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
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
</aside>