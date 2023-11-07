<?php

namespace App\Livewire;

use App\Models\Parametre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

class LogAgent extends AppComponent
{
    private static array $headers = [
        'Login',
        'Utilisateur',
        'Jour',
        'Heure',
    ];

    #[Url]
    public $date_from;
    #[Url]
    public $date_to;
    #[Url]
    public $user_id;
    public $users;

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');
        
        $this->date_from = now()->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
        $this->users = in_array(Auth::user()->type_id, [1, 2]) ?
            User::all() :
            User::where('zone_id', Auth::user()->zone_id)->get();
        // dd($this->date_search);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Log par agent')]
    public function render()
    {
        // dd($this->date_search);
        if($this->user_id != 0)
            $lesUsers = [$this->user_id];
        else
            $lesUsers = $this->users->pluck('id')->toArray();
        $items = User::leftJoin('logs', 'users.id', 'logs.user_id')
        ->selectRaw("
            users.login,
            CONCAT(users.nom, ' ', users.prenom) as utilisateur,
            MIN(logs.date) as connexion,
            DATE_FORMAT(logs.date, '%Y-%m-%d') as day
        ")
        ->where('logs.libelle', 'connexion')
        ->whereDate('logs.date', '>=', $this->date_from)
        ->whereDate('logs.date', '<=', $this->date_to)
        ->whereIn('users.id', $lesUsers)
        ->groupBy('day', 'login', 'users.nom', 'users.prenom')
        ->get();

        $parametre = Parametre::findOrFail(1);
        return view('livewire.log-agent', [
            'items' => $items,
            'parametre' => $parametre,
            'headers' => self::$headers,
        ]);
    }
}
