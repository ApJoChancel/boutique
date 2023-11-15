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
    public $login = null;
    #[Rule('required')]
    public $password = null;
    public $voir_mdp;
    
    public function mount()
    {
        $this->textSubmit = 'Se connecter';
    }
    
    public function save(Request $request)
    {
        $this->validate();
        // dd($request);
        $item = User::where('login', $this->login)->first();
        if(password_verify($this->password, $item?->password)){
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

        // function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
        //     $theta = $longitude1 - $longitude2; 
        //     $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        //     $distance = acos($distance); 
        //     $distance = rad2deg($distance); 
        //     $distance = $distance * 60 * 1.1515; 
        //     switch($unit) { 
        //         case 'miles': 
        //         break; 
        //         case 'kilometers' : 
        //         $distance = $distance * 1.609344; 
        //     } 
        //     return (round($distance,2)); 
        // }
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
