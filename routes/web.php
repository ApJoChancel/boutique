<?php

use App\Livewire\Article;
use App\Livewire\Boutique;
use App\Livewire\Caracteristique;
use App\Livewire\Categorie;
use App\Livewire\Role;
use App\Livewire\User;
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

Route::get('user', User::class);
Route::get('role', Role::class);
Route::get('boutique', Boutique::class);
Route::get('categorie', Categorie::class);
Route::get('carac', Caracteristique::class);
Route::get('article', Article::class);
