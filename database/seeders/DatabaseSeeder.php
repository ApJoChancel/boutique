<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'libelle' => 'Manager'
            ],
            [
                'id' => 2,
                'libelle' => 'Commercial'
            ],
        ]);

        DB::table('types')->insert([
            [
                'id' => 1,
                'libelle' => 'Admin'
            ],
            [
                'id' => 2,
                'libelle' => 'Suppléant'

            ],
            [
                'id' => 3,
                'libelle' => 'Superviseur'
            ],
            [
                'id' => 4,
                'libelle' => 'Commercial'
            ],
        ]);

        DB::table('users')->insert([
            [
                'login' => 'ADM0001',
                'nom' => 'DOE',
                'prenom' => 'John',
                'password' => Hash::make('password'),
                'type_id' => 1,
            ],
        ]);
    }
}
    