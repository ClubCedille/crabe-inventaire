<?php

use Illuminate\Database\Seeder;

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
        ]);

        factory(App\User::class, 20)->create()->each(function ($user) {
            $user->save();
        });
    }
}
