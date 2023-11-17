<?php

namespace App\Livewire;

use App\Models\Parametre;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

class LogAgent extends AppComponent
{
    private static array $headers = [
        'Jour',
        'Login',
        'Utilisateur',
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

        $logs = [];
        foreach($items as $item){
            if(isset($logs[$item->day]['count'])){
                $logs[$item->day]['count'] += 1;
            } else{
                $logs[$item->day]['count'] = 1;
            }
            //On reformate les heures de connexion
            $dateTimeStringToTimeString = explode(' ', $item->connexion)[1];
            $timeToStringToDateTimeString = "2024-01-01 {$dateTimeStringToTimeString}";
            $dateTimeStringToDateTime = new DateTime($timeToStringToDateTimeString);
            $dateTimeToTime = $dateTimeStringToDateTime->format('Y-m-d H:i');
            $item->connexion = $dateTimeToTime;

            $logs[$item->day]['logs'][] = $item;
        }
        //On reformate la date en paramètre en ajoutant le delais de retard
        $parametre = Parametre::findOrFail(1);
        $parametre->heure = "2024-01-01 {$parametre->heure}";
        $parametre->heure = new DateTime($parametre->heure);
        $parametre->heure->add(new DateInterval("PT{$parametre->delais_retard}M"));
        $parametre->heure = $parametre->heure->format('Y-m-d H:i');

        return view('livewire.log-agent', [
            'items' => $logs,
            'parametre' => $parametre,
            'headers' => self::$headers,
        ]); 
    }
}
