<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class Auth extends AppComponent
{
    
    #[Rule('required')]
    public $email = null;
    #[Rule('required')]
    public $password = null;

    public function save(Request $request)
    {
        $this->validate();
        $item = User::where('email', $this->email)->first();
        if(password_verify($this->password, $item?->password)){
            $request->session()->regenerate();
            DB::beginTransaction();
                FacadesAuth::attempt($this->validate());
                $log = new Log();
                $log->libelle = 'connexion';
                $log->date = now();
                $log->user()->associate($item->id);
                if($item->boutique)
                    $log->boutique()->associate($item->boutique->id);
                $log->save();
            DB::commit();
            return redirect()->intended(route('compte'));
        }

        $this->addError('email', 'Informations incorrectes');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->email =
        $this->password = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Auth')]
    public function render()
    {
        return view('livewire.auth');
    }
}
