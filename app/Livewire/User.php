<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\Type;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

class User extends AppComponent
{
    const DEFAULT_PASSWORD = 'password';

    #[Rule('required|min:5|unique:users')]
    public $login = null;
    #[Rule('required')]
    public $nom = null;
    #[Rule('required')]
    public $prenom = null;
    #[Rule('required')]
    public $role_id = null;
    #[Rule('required')]
    public $type_id = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsUser() : ModelsUser::findOrFail($this->edit_id);
        $item->login = $this->login;
        $item->nom = $this->nom;
        $item->prenom = $this->prenom;
        $item->role_id = $this->role_id;
        $item->type_id = $this->type_id;
        $item->password = Hash::make(self::DEFAULT_PASSWORD);
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Added successfully');
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
        session()->flash('status', 'Deleted successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->login =
            $this->nom =
            $this->prenom =
            $this->type_id =
            $this->role_id = null;
    }

    public function resetPassword(ModelsUser $item)
    {
        $item->password = Hash::make(self::DEFAULT_PASSWORD);
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
    }

    public function mount()
    {
        $this->type_id = 4; //Commercial
        $this->role_id = 2; //Commercial
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | User')]
    public function render()
    {
        return view('livewire.user', [
            'roles' => Role::all(),
            'types' => Type::all(),
            'users' => ModelsUser::all(),
        ]);
    }
}
