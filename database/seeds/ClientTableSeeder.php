<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
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
        DB::table('oauth_clients')->truncate();

        /*
         * Create client oauth
         */
        DB::table('oauth_clients')->insert([
            'id' => 987654321,
            'secret' => '987654321_dream',
            'name' => 'dream'
        ]);
    }
}
