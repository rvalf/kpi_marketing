<?php

namespace Database\Seeders;

use App\Models\Divisi;
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
        $divisi = Divisi::firstOrCreate(['name' => 'Manager']);

        $user = new User();
        $user->username = 'manager01';
        $user->fullname = 'Revalina Fitriani';
        $user->email = 'reva@example.com';
        $user->password = Hash::make('password');
        $user->divisi_id = $divisi->id;
        $user->save();
    }
}
