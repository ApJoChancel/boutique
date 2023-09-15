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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('roles')->insert([
            [
                'libelle' => 'Propriétaire'
            ],
            [
                'libelle' => 'Manager'
            ],
        ]);

        DB::table('users')->insert([
            [
                'email' => 'johndoe@gmail.com',
                'noms' => 'John',
                'password' => Hash::make('password'),
                'role_id' => 1,
                // 'boutique_id' => 1,
            ],
        ]);
    }
}
