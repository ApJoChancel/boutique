<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Auth extends AppComponent
{
    #[Rule('required')]
    public $login;
    #[Rule('required')]
    public $password;
    public $voir_mdp;

    public $latitude;
    public $longitude;
    
    public function mount()
    {
        $this->textSubmit = 'Se connecter';
    }
    
    public function save(Request $request)
    {
        $this->validate();
        $item = User::where('login', $this->login)->first();
        if(password_verify($this->password, $item?->password)){
            //La géolocalisation
            // dd($this);
            if(!$this->latitude || !$this->longitude){
                $this->addError('login', 'Impossible de vous localiser. Rechargez la page.');
                return;
            }
            if ((!empty($item->boutique)) && ($item->type_id === 4)) {
                $distance = self::getDistanceBetweenPoints($this->latitude, $this->longitude,
                    $item->boutique->latitude, $item->boutique->longitude);
                if($distance > 100){
                    $this->addError('login', 'Vous êtes hors zone');
                    return;
                }
            }
            $request->session()->regenerate();
            DB::beginTransaction();
                FacadesAuth::login($item);
                $log = new Log();
                $log->libelle = 'connexion';
                $log->date = now();
                $log->user()->associate($item->id);
                if($item->boutique)
                    $log->boutique()->associate($item->boutique->id);
                $log->save();
            DB::commit();
            return redirect()->intended(route('stat_objectif'));
        }

        $this->addError('login', 'Informations incorrectes');
    }
    public function getDistanceBetweenPoints(float $latitude1, float $longitude1, float $latitude2, float $longitude2)
    {
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) +
            (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance);
        ///En miles
        $distance = $distance * 60 * 1.1515;
        //En mètres
        $distance = $distance * 1609.344;
        return (round($distance,0));
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->login =
        $this->password = null;
        $this->voir_mdp = null;
    }

    #[Layout('livewire.layouts.login')]
    #[Title('Boutique | Auth')]
    public function render()
    {
        return view('livewire.auth');
    }
}
