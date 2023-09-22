<?php

namespace App\Livewire;

use Livewire\Component;

class AppComponent extends Component
{
    const TEXT_SUBMIT = 'Enregistrer';
    public $edit_id = null;
    public $delete_id = null;
    public $textSubmit = self::TEXT_SUBMIT;

    public $confirm_modal = false;
    public $change_modal = false;

    public function deleteItem(mixed $item)
    {
        $this->delete_id = $item->id;
        $this->confirm_modal = true;

    }

    public function deleteCancelled()
    {
        $this->resetValues();
        $this->confirm_modal = false;
    }

    public function deleteConfirmed(mixed $item)
    {
        $item->delete();
        $this->resetValues();
        $this->confirm_modal = false;
        $this->dispatch('close-toast-after-3-seconds'); 
    }

    public function closeToast()
    {
        $this->dispatch('close-toast'); 
    }

    public function resetValues()
    {
        $this->edit_id =
            $this->delete_id = null;
        $this->textSubmit = self::TEXT_SUBMIT;

        $this->confirm_modal =
            $this->change_modal = false;
    }

    public function notificationToast(string $message)
    {
        session()->flash('status', $message);
        $this->dispatch('close-toast-after-3-seconds');
    }
}
