<?php

namespace App\Livewire;

use App\Models\Parametre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

class Log extends AppComponent
{
    private static array $headers = [
        'Login',
        'Utilisateur',
        'Heure',
    ];

    #[Url]
    public $date_search;
    public $users_valdes;

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');

        $this->date_search = now()->format('Y-m-d');
        $this->users_valdes = in_array(Auth::user()->type_id, [1, 2]) ?
            User::all()->pluck('id')->toArray() :
            User::where('zone_id', Auth::user()->zone_id)->get()->pluck('id')->toArray();
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Log')]
    public function render()
    {
        $items = User::select(
            'users.login',
            'users.nom',
            'users.prenom',
            DB::raw('MIN(logs.date) as connexion')
        )
        ->leftJoin('logs', 'users.id', 'logs.user_id')
        ->where('logs.libelle', 'connexion')
        ->whereDate('logs.date', $this->date_search)
        ->whereIn('users.id', $this->users_valdes)
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
