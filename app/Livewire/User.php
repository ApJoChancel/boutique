<?php

namespace App\Livewire;

use App\Models\Boutique;
use App\Models\Role;
use App\Models\Type;
use App\Models\User as ModelsUser;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class User extends AppComponent
{
    use WithPagination;

    private static array $headers = [
        'Login',
        'Noms et prénoms',
        'Type',
        'Role',
        'Zone',
        'Boutique',
    ];

    const DEFAULT_PASSWORD = 'password';

    #[Rule('required|min:5|unique:users')]
    public $login;
    #[Rule('required')]
    public $nom;
    #[Rule('required')]
    public $prenom;

    public $role_id;
    public $type_id;
    public $zone_id;
    public $boutique_id;

    public $voirRole;
    public $voirZone;
    public $voirBoutique;

    public $boutiques;

    public function mount()
    {
        $this->boutiques = Boutique::all();

        $this->type_id = 4; //Commercial
        $this->role_id = 2; //Commercial
        $this->voirRole =
            $this->voirZone =
            $this->voirBoutique = true;
    }

    public function changeType()
    {
        if($this->type_id == 1 || $this->type_id == 2){
            $this->voirRole =
            $this->voirZone =
            $this->voirBoutique = false;
        } elseif($this->type_id == 3){
            $this->voirZone = true;

            $this->voirRole =
            $this->voirBoutique = false;
        } elseif($this->type_id == 4){
            $this->voirZone =
            $this->voirRole =
            $this->voirBoutique = true;
        }
    }

    public function changeZone()
    {
        if($this->zone_id){
            $zone = Zone::findOrFail($this->zone_id);
            $this->boutiques = $zone->boutiques;
        }
    }

    public function save()
    {
        $this->validate();
        //Nom et prenom unique
        $exite = DB::table('users')->where('nom', $this->nom)
            ->where('prenom', $this->prenom)
            ->first();
        if(!$exite){
            $item = new ModelsUser();
            $item->login = $this->login;
            $item->nom = $this->nom;
            $item->prenom = $this->prenom;
            $item->password = Hash::make(self::DEFAULT_PASSWORD);
            switch ($this->type_id) {
                case 1 : //Admin
                case 2 : //Suppléant
                    //On s'assure qu'il n'y a qu'un suppléant
                    if($this->type_id == 2){ //Suppléant
                        $exist = ModelsUser::where('type_id', $this->type_id)->first();
                        if($exist){
                            $this->addError('type_id', 'Un suppléant existe déjà');
                            return;
                        }
                    }
                    $item->type_id = $this->type_id;
                    break;

                case 3 : //Superviseur
                    //On s'assure qu'il n'y a aucun superviseur dans cette zone
                    $exist = ModelsUser::where('zone_id', $this->zone_id)->first();
                    if($exist){
                        $this->addError('zone_id', 'Cette zone a déjà un superviseur');
                        return;
                    }
                    $item->type_id = $this->type_id;
                    $item->zone_id = $this->zone_id;
                    break;
                
                case 4 : //Commercial
                    if($this->role_id == 1){ //Manager
                        //On s'assure qu'il n'y a pas déjà un manager dans la boutique
                        $exist = ModelsUser::where('boutique_id', $this->boutique_id)
                            ->where('role_id', $this->role_id)->first();
                        if($exist){
                            $this->addError('boutique_id', 'Cette boutique a déjà un manager');
                            return;
                        }
                    }
                    $item->type_id = $this->type_id;
                    $item->role_id = $this->role_id;
                    $item->boutique_id = $this->boutique_id;
                    break;
            }
            $item->save();
            $this->resetValues();
            $this->notificationToast(self::TEXT_SAVED);
        } else{
            $this->addError('nom', 'Un utilisateur existe avec ce nom et ce prénom');
        }
    }

    public function editItem(ModelsUser $user)
    {
        $this->edit_id = $user->id;
        $this->login = $user->login;
        $this->nom = $user->nom;
        $this->prenom = $user->prenom;
        $this->role_id = $user->role_id;
        $this->type_id = $user->type_id;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsUser::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsUser::findOrFail($id));
        $this->notificationToast(self::TEXT_DELETE);
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->login =
            $this->nom =
            $this->prenom =
            $this->type_id =
            $this->boutique_id =
            $this->zone_id =
            $this->role_id = null;
    }

    public function resetPassword(ModelsUser $item)
    {
        $item->password = Hash::make(self::DEFAULT_PASSWORD);
        $item->save();
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    public function changeInfo(ModelsUser $item)
    {
        $this->edit_id = $item->id;
        $this->login = $item->nom;
        $this->nom = $item->nom;
        $this->prenom = $item->prenom;
        $this->textSubmit = 'Modifier';
        $this->change_modal = true;
    }

    public function changeInfoData()
    {
        $this->validate();
        $item = ModelsUser::findOrFail($this->edit_id);
        $item->nom = $this->nom;
        $item->prenom = $this->prenom;
        $item->save();
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | User')]
    public function render()
    {
        return view('livewire.user', [
            'roles' => Role::all(),
            'types' => Type::all(),
            'zones' => Zone::all(),
            // 'boutiques' => Boutique::all(),
            'users' => ModelsUser::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
