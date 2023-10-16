<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    const DEFAULT_OBJECTIF = 2000000;
    
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'id' => 1,
                'libelle' => "Canal de visite",
                'ordre' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'libelle' => "Profil du visiteur",
                'ordre' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'libelle' => "Tranche d'âge",
                'ordre' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'libelle' => 'Profession',
                'ordre' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'libelle' => 'Lieu de résidence',
                'ordre' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('choix')->insert([
            [
                'libelle' => 'Bouche à oreille',
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'De passage',
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Facebook',
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Instagram',
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Tiktok',
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "Recommandation d'un proche",
                'type' => 'text',
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Femme',
                'type' => 'text',
                'question_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Fille',
                'type' => 'text',
                'question_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Homme',
                'type' => 'text',
                'question_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Garçon',
                'type' => 'text',
                'question_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '0 - 14',
                'type' => 'text',
                'question_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '15 - 24',
                'type' => 'text',
                'question_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '25 - 34',
                'type' => 'text',
                'question_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '45 - plus',
                'type' => 'text',
                'question_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Salarié publique',
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Salarié privé',
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Commerçant',
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "Homme d'affaire",
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Retraité',
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chômage',
                'type' => 'text',
                'question_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Yaoundé',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Douala',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bamenda',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Buea',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bafoussam',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Ebolowa',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bertoua',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Ngaoundere',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Garoua',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Maroua',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Autre',
                'type' => 'text',
                'question_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('zones')->insert([
            [
                'id' => 1,
                'libelle' => 'Région du Centre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'libelle' => 'Région du Littoral',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('boutiques')->insert([
            [
                'designation' => 'CN Ynde Vallée Nlongkak',
                'objectif' => self::DEFAULT_OBJECTIF,
                'zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'designation' => 'CN Dla Akwa Bonakouamouang',
                'objectif' => self::DEFAULT_OBJECTIF,
                'zone_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('categories')->insert([
            [
                'id' => 1,
                'libelle' => 'Robes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'libelle' => 'Chaussures',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'libelle' => 'Bijoux',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'libelle' => 'Accessoires',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'libelle' => 'Autres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('articles')->insert([
            [
                'libelle' => 'Robe de mariage sirène',
                'categorie_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Robe de mariage princesse',
                'categorie_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chaussure escarpins',
                'categorie_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chaussure sandale',
                'categorie_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Colliers',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bagues',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Couronne',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Barettes',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Boucles',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bracelets',
                'categorie_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Cerceaux',
                'categorie_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Voiles',
                'categorie_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bibi',
                'categorie_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Pochettes',
                'categorie_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "Livre d'or",
                'categorie_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bouquets de fleurs',
                'categorie_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "Billet d'invitation",
                'categorie_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Gadgets',
                'categorie_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Porte alliance',
                'categorie_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('caracteristiques')->insert([
            [
                'libelle' => 'Modèle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Taille',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Pointure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Couleur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Marque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

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
                'nom' => 'ZOCK',
                'prenom' => 'Ronald',
                'password' => Hash::make('password'),
                'type_id' => 1,
            ],
            [
                'login' => 'ADM0002',
                'nom' => 'Mme ZOCK',
                'prenom' => 'Corlette',
                'password' => Hash::make('password'),
                'type_id' => 1,
            ],
        ]);

        DB::table('parametres')->insert([
            [
                'delais_vente' => 30,
                'delais_location' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
