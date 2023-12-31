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
                'libelle' => 'Ancien client',
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
                'libelle' => '35 - 44',
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

       

        DB::table('caracteristiques')->insert([
            [
                'id' => 1,
                'libelle' => 'Modèle',
                'type' => 'unique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'libelle' => 'Taille',
                'type' => 'unique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'libelle' => 'Pointure',
                'type' => 'unique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'libelle' => 'Couleur',
                'type' => 'unique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'libelle' => 'Marque',
                'type' => 'unique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'libelle' => 'Type',
                'type' => 'multiple',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('options')->insert([
            [
                'libelle' => 'Robes cocktail jour',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Robes cocktail nuit',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Robes mariage Sirène',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Robes mariage Princesse',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chaussures à talons',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chaussures plates',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bottes',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Mules',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Chaussures à sabots',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sacs bandoulières',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sacs fourre-tout',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Porte monnaie',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Pochettes',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sacs banane',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sacs à main',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Montres',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Lunettes de soleil',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Gants',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Accessoires de cheveux',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Ceintures',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Écharpes',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Châles',
                'caracteristique_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '20',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '21',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '22',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '23',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '24',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '25',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '26',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '26',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '27',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '28',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '29',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '30',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '31',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '32',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '33',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '34',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '35',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '36',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '37',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '38',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '39',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '40',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '41',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '42',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '43',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '44',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '45',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '46',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '47',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '48',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '49',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '50',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '51',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '52',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '53',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '54',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => '55',
                'caracteristique_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bleu',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Vert',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Jaune',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Rouge',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Orange',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Indigo',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Violet',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Noir',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Blanc',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Marron',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Belge',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Saumon',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Gris',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Rose',
                'caracteristique_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Avec perles',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sans perles',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Avec traîne',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sans traîne',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Une pièce',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Deux pièces',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Sans manches ou bustier',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Longues manches',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Manches 3/4',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Décolté ou col bateaux',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Démembré',
                'caracteristique_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Bretelles',
                'caracteristique_id' => 6,
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
