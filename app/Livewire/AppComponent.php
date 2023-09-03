<?php

namespace App\Livewire;

use Livewire\Component;

class AppComponent extends Component
{
    const TEXT_SUBMIT = 'Enregistrer';
    public $edit_id = null;
    public $delete_id = null;
    public $textSubmit = self::TEXT_SUBMIT;

    public function deleteItem(mixed $item)
    {
        $this->delete_id = $item->id;
        $this->dispatch('show-confirm');
    }

    public function deleteCancelled()
    {
        $this->resetValues();
        $this->dispatch('close-modal'); 
    }

    public function deleteConfirmed(mixed $item)
    {
        $item->delete();
        $this->resetValues();
        $this->dispatch('close-modal'); 
    }

    public function resetValues()
    {
        $this->edit_id =
            $this->delete_id = null;
        $this->textSubmit = self::TEXT_SUBMIT;
    }
}
