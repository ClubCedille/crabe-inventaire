<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => "Club",
            'lastName' => 'Cedille',
            'codeUniversel' => 'AP123456',
            'isAdmin' => true,
            'email' => 'cedille@etsmtl.net',
            'password' => bcrypt('secret'),
            'membershipExpirationDate' => carbon::now()->add(3, 'year'),
        ]);

        DB::table('users')->insert([
            'firstName' => "Utilisateur",
            'lastName' => 'PasMembre',
            'codeUniversel' => 'AP123457',
            'email' => 'pasmembre@etsmtl.net',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'firstName' => "Utilisateur",
            'lastName' => 'Membre',
            'codeUniversel' => 'AP123458',
            'email' => 'membre@etsmtl.net',
            'password' => bcrypt('secret'),
            'membershipExpirationDate' => carbon::now()->add(3, 'year'),
        ]);

        factory(App\User::class, 20)->create()->each(function ($user) {
            $user->save();
        });
    }
}
