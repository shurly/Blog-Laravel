<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'Anonimo',
           'email' => 'anonimo@gmail.com',
           'password' => bcrypt('shdkyd&3kd1'), //147258
           'bibliography' => 'Usuário Anônimo',
        ]);

    }
}
