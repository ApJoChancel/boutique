<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class User extends Component
{
    #[Rule('required|min:5|unique:users')]
    public $login = null;
    #[Rule('required')]
    public $role_id = null;

    public function register()
    {
        $this->validate();
        $item = new ModelsUser();
        $item->login = $this->login;
        $item->role_id = 1;
        $item->password = Hash::make('password');
        $item->save();
        $this->login = $this->role = null;
    }

    public function render()
    {
        return view('livewire.user', [
            'roles' => Role::all(),
            'users' => ModelsUser::all(),
        ])->layout('livewire.layouts.base');
    }
}
