<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['email' => 'test1@mail.it', 'password' => 'password', 'name' => 'test 1', 'surname' => 'test 1', 'date_of_birth' => '01-11-2002'],
            ['email' => 'test2@mail.it', 'password' => 'password', 'name' => 'test 2', 'surname' => 'test 2', 'date_of_birth' => '01-11-2002'],
            ['email' => 'test3@mail.it', 'password' => 'password', 'name' => 'test 3', 'surname' => 'test 3', 'date_of_birth' => '01-11-2002'],
        ];

        foreach ($users as $user) {
            $newuser = new User();

            $newuser->email = $user['email'];
            $newuser->password = Hash::make($user['password']);
            $newuser->name = $user['name'];
            $newuser->surname = $user['surname'];
            $newuser->date_of_birth = null;

            $newuser->save();
        }
    }
}
