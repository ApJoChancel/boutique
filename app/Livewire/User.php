<?php

namespace App\Livewire;

use App\Models\Role;
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
    public $role_id = null;

    public function register()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsUser() : ModelsUser::findOrFail($this->edit_id);
        $item->login = $this->login;
        $item->role_id = $this->role_id;
        $item->password = Hash::make(self::DEFAULT_PASSWORD);
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Added successfully');
    }

    public function editItem(ModelsUser $user)
    {
        $this->edit_id = $user->id;
        $this->login = $user->login;
        $this->role_id = $user->role_id;
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
            $this->role_id = null;
    }

    public function resetPassword(ModelsUser $item)
    {
        $item->password = Hash::make(self::DEFAULT_PASSWORD);
        $item->save();
        $this->resetValues();
        session()->flash('status', 'Changed successfully');
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | User')]
    public function render()
    {
        return view('livewire.user', [
            'roles' => Role::all(),
            'users' => ModelsUser::all(),
        ]);
    }
}
