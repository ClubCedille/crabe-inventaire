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
        DB::table('users')->insert([
            'firstName' => "Club",
            'lastName' => 'Cedille',
            'codeUniversel' => 'AP123456',
            'chipNumber' => '2313211234',
            'isAdmin' => true,
            'email' => 'cedille@etsmtl.net',
            'password' => bcrypt('secret'),
            'email_verified_at' => carbon::now(),
            'membershipExpirationDate' => carbon::now()->add(3, 'year'),
        ]);
        $id = DB::getPdo()->lastInsertId();;
        DB::table('carts')->insert([
            'user_id' => $id ,
        ]);

         /**
         * Create user not admin and not memmber yet
        */
        DB::table('users')->insert([
            'firstName' => "james",
            'lastName' => 'bob',
            'codeUniversel' => 'AN123456',
            'chipNumber' => '2313881234',
            'isAdmin' => false,
            'email' => 'james@etsmtl.ca',
            'password' => bcrypt('secret'),
            'email_verified_at' => carbon::now(),
            'membershipExpirationDate' => carbon::now(),
        ]);
        
        $id = DB::getPdo()->lastInsertId();;
        DB::table('carts')->insert([
            'user_id' => $id ,
        ]);
       
        ///factory(App\User::class, 20)->create()->each(function ($user) {
           // $user->save();
        //});
    }
}
