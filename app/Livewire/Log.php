<?php

namespace App\Livewire;

use App\Models\Parametre;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class Log extends Component
{
    private static array $headers = [
        'Login',
        'Utilisateur',
        'Heure',
    ];

    #[Url]
    public $date_search = null;

    public function mount()
    {
        $this->date_search = now()->format('Y-m-d');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Log')]
    public function render()
    {
        $items = User::leftJoin('logs', 'users.id', 'logs.user_id')
        ->select(
            'users.login',
            'users.nom',
            'users.prenom',
            DB::raw('MIN(logs.date) as connexion'))
        ->where('logs.libelle', 'connexion')
        ->whereDate('logs.date', $this->date_search)
        ->groupBy('users.login', 'users.nom', 'users.prenom')
        ->get();

        $parametre = Parametre::findOrFail(1);
        return view('livewire.log', [
            'items' => $items,
            'parametre' => $parametre,
            'headers' => self::$headers,
        ]);
    }
}
