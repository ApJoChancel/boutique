<?php

namespace App\Livewire;

use App\Models\Evenement as ModelsEvenement;
use Illuminate\Support\Facades\Auth;
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

    public function mount()
    {
        $this->is_com = (Auth::user()->type_id === 4)? true : false;
        abort_if($this->is_com, 403, 'Autorisation refusée');
    }

    public function fermer(ModelsEvenement $item)
    {
        $this->is_com_or_supper = in_array(Auth::user()->type_id, [3, 4]) ? true : false;
        abort_if($this->is_com_or_supper, 403, 'Autorisation refusée');

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
