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
        'Jour',
        'Heure',
    ];

    #[Url]
    public $date_search;
    #[Url]
    public $user_id;
    public $users;

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');
        
        $this->date_search = now()->format('Y-m');
        $this->users = in_array(Auth::user()->type_id, [1, 2]) ?
            User::all() :
            User::where('zone_id', Auth::user()->zone_id)->get();
        $this->textSubmit = 'Rapport';
        // dd($this->date_search);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Log par agent')]
    public function render()
    {
        // dd($this->date_search);
        $items = User::leftJoin('logs', 'users.id', 'logs.user_id')
        ->selectRaw("
            MIN(logs.date) as connexion,
            DAY(logs.date) as day
        ")
        ->where('logs.libelle', 'connexion')
        ->whereYear('logs.date', explode('-', $this->date_search)[0])
        ->whereMonth('logs.date', explode('-', $this->date_search)[1])
        ->where('users.id', $this->user_id)
        ->groupBy('day')
        ->get();

        $parametre = Parametre::findOrFail(1);
        return view('livewire.log-agent', [
            'items' => $items,
            'parametre' => $parametre,
            'headers' => self::$headers,
        ]);
    }
}
