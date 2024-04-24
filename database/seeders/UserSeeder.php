<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Ferdinando';
        $user->email = 'd.patane98@gmail.com';
        $user->password = md5('280287Da');
        $user->save();

        $user = new User();
        $user->name = 'Agata';
        $user->email = 'd.patane98@gmail.it';
        $user->password = md5('280287Da');
        $user->save();
    }
}
