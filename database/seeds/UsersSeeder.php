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
        /**
         * Create the first user as am admin
        */
        $userId =  DB::table('users')->insert([
            'firstName' => "Club",
            'lastName' => 'Cedille',
            'codeUniversel' => 'AP123456',
            'isAdmin' => true,
            'email' => 'cedille@etsmtl.net',
            'password' => bcrypt('secret'),
            'email_verified_at' => carbon::now(),
            'membershipExpirationDate' => carbon::now()->add(3, 'year'),
        ]);
        DB::table('carts')->insert([
            'user_id' => $userId,
        ]);
       
        ///factory(App\User::class, 20)->create()->each(function ($user) {
           // $user->save();
        //});
    }
}
