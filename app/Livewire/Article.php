<?php

namespace App\Livewire;

use App\Models\Article as ModelsArticle;
use App\Models\Categorie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Article extends AppComponent
{
    use WithPagination;

    private static array $headers = [
        'Article',
        'Catégorie',
    ];
    
    #[Rule('required|unique:articles')]
    public $libelle = null;
    #[Rule('sometimes')]
    public $categorie_id = null;

    public function save()
    {
        $this->validate();
        $item = (!$this->edit_id) ? new ModelsArticle() : ModelsArticle::findOrFail($this->edit_id);
        $item->libelle = $this->libelle;
        if($this->categorie_id)
            $item->categorie_id = $this->categorie_id;
        $item->save();
        $this->resetValues();
        $this->notificationToast(self::TEXT_SAVED);
    }

    public function editItem(ModelsArticle $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->libelle;
        $this->categorie_id = null;
        $this->textSubmit = 'Modifier';
    }

    public function deleteItem(mixed $id)
    {
        $item = ModelsArticle::findOrFail($id);
        if($item->ligneVentes->get(0)){
            $this->notificationToast('Suppression refusée. L\'article est impliquée
                dans une ou plusieurs ventes');
            $this->resetValues();
            return;
        }
        parent::deleteItem($item);
    }

    public function deleteConfirmed(mixed $id)
    {
        parent::deleteConfirmed(ModelsArticle::findOrFail($id));
        $this->notificationToast(self::TEXT_DELETE);
    }

    public function resetValues()
    {
        parent::resetValues();
        $this->libelle =
            $this->categorie_id = null;
    }

    public function changeCategorie(ModelsArticle $item)
    {
        $this->edit_id = $item->id;
        $this->libelle = $item->categorie->libelle;
        $this->categorie_id = $item->categorie->id;
        $this->change_modal = true;
    }

    public function changeCategorieData()
    {
        $this->validate();
        $item = ModelsArticle::findOrFail($this->edit_id);
        $categorie = Categorie::findOrFail($this->categorie_id);
        $item->categorie()->associate($categorie);
        $item->save();
        $this->change_modal = false;
        $this->resetValues();
        $this->notificationToast(self::TEXT_MODIFY);
    }

    #[Layout('livewire.layouts.base')]
    #[Title('Boutique | Article')]
    public function render()
    {
        return view('livewire.article', [
            'categories' => Categorie::all(),
            'articles' => ModelsArticle::paginate(10),
            'headers' => self::$headers,
        ]);
    }
}
