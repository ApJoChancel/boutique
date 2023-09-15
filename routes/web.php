<?php

use App\Livewire\Article;
use App\Livewire\Auth;
use App\Livewire\Boutique;
use App\Livewire\Caracteristique;
use App\Livewire\Categorie;
use App\Livewire\Compte;
use App\Livewire\Logout;
use App\Livewire\Recouvrement;
use App\Livewire\Role;
use App\Livewire\Sondage;
use App\Livewire\User;
use App\Livewire\Vente;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth', Auth::class)->middleware('guest')->name('login');

Route::middleware('auth')->group(function() {
    Route::get('logout', Logout::class)->name('logout');
    Route::get('user', User::class)->name('user');
    Route::get('role', Role::class)->name('role');
    Route::get('boutique', Boutique::class)->name('boutique');
    Route::get('categorie', Categorie::class)->name('categorie');
    Route::get('carac', Caracteristique::class)->name('carac');
    Route::get('article', Article::class)->name('article');
    Route::get('sondage', Sondage::class)->name('sondage');
    Route::get('vente', Vente::class)->name('vente');
    Route::get('rec', Recouvrement::class)->name('rec');
    Route::get('compte', Compte::class)->name('compte');
});
