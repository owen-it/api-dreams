<?php

use Illuminate\Database\Seeder;

class DreamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Remove all registry for popular again
         * from the beginning.
         */
        DB::table('dreams')->truncate();
        DB::table('users')->truncate();

        /*
         * Factory to users
         */
        factory(App\Entity\User::class, 10)->create()->each(function($user)
        {
            /*
             * Factory to dreams
             */
            $user->dreams()->saveMany(factory(App\Entity\Dream::class, rand(3,9))->make());
        });
    }
}
