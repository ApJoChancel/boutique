<?php

namespace App\Livewire;

use App\Models\Choix;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Sondage extends AppComponent
{
    public $question = '';
    public $choix = [
        [
            'libelle' => '',
            'type' => 'text',
            'complement' => '',
        ],
    ];

    public function addChoix()
    {
        $this->choix[] = [
            'libelle' => '',
            'type' => 'text',
            'complement' => '',
        ];
    }

    public function updated()
    {
        $this->dispatch('update-script');
    }


    public function removeChoix($index)
    {
        unset($this->choix[$index]);
        $this->choix = array_values($this->choix); // Réindexer les clés
    }

    public function save()
    {
        // Valider les données du formulaire
        $validatedData = Validator::make([
            'question' => $this->question,
            'choix' => $this->choix,
        ], [
            'question' => 'required|string|max:255',
            'choix.*.libelle' => 'required|string|max:255',
            'choix.*.type' => 'required|in:text,unique,multiple',
            'choix.*.complement' => 'sometimes|required_if:choix.*.type,unique,multiple',
        ])->validate();

        DB::beginTransaction();
            $question = new Question();
            $question->libelle = $this->question;
            $question->ordre = 1;
            $question->save();
            //
            foreach($this->choix as $table){
                $choix = new Choix();
                $choix->libelle = $table['libelle'];
                $choix->type = $table['type'];
                $choix->question_id = $question->id;
                $choix->save();
                if($table['type'] !== 'text'){
                    $table['complement'] = nl2br($table['complement']);
                    foreach(explode('<br />', $table['complement']) as $comp){
                        $comp = trim($comp);
                        $opt = new Choix();
                        $opt->libelle = $comp;
                        $opt->type = 'text';
                        $opt->choix_id = $choix->id;
                        $opt->question_id = $question->id;
                        $opt->save();
                    }
                }
            }
        DB::commit();
        $this->resetValues();
        session()->flash('status', 'Added successfully');
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->question = null;
        $this->choix = [
            [
                'libelle' => '',
                'type' => 'text',
                'complement' => '',
            ],
        ];
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Sondage')]
    public function render()
    {
        return view('livewire.sondage');
    }
}
