<?php

namespace App\Livewire;

use App\Models\Zone as ModelsZone;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Zone extends AppComponent
{
    use WithPagination;

    private static array $headers = [
        'Libellé',
    ];

    #[Rule('required|unique:zones')]
    public $libelle = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsZone() : ModelsZone::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        $item->save();
        $this->resetValues();
        $this->notificationToast(self::TEXT_SAVED);
    }

    public function editItem(ModelsZone $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        parent::deleteItem(ModelsZone::findOrFail($id));
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsZone::findOrFail($id));
        $this->notificationToast(self::TEXT_DELETE);

    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle = null;
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Zone')]
    public function render()
    {
        return view('livewire.zone', [
            'zones' => ModelsZone::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
