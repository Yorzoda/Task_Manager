<?php

use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "John",
            'email' => 'test'.'@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        DB::table('users')->insert([ 
            'name' => "Mike",
            'email' => 'some'.'@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => "Bill",
            'email' => 'micro'.'@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
    }
}
