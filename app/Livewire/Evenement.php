<?php

namespace App\Livewire;

use App\Models\Evenement as ModelsEvenement;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Evenement extends AppComponent
{
    private static array $headers = [
        'Date',
        'Description',
        'Client',
        'Téléphone',
        'Action'
    ];

    public function fermer(ModelsEvenement $item)
    {
        $item->vu = true;
        $item->save();
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Statistiques - Evènements')]
    public function render()
    {
        return view('livewire.evenement',[
            'events' => ModelsEvenement::where('vu', false)->orderByDesc('date_event')->get(),
            'headers' => self::$headers,
        ]);
    }
}
