<?php
use Illuminate\Database\Seeder;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'first_name' => 'John',
            'last_name' => 'Parrado',
            'username' => 'japarradog',
            'email' => 'japarradog@gmail.com',
            'role' => 'admin',
        ]);
    }
}