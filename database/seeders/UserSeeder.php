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
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jamshid',
            'surname' => 'Rajabov',
            'photo' => 'default.jpg',
            'phone' => '+998994205841',
            'passport' => 'KA1111111',
            'birth' => '21.06.2002',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Teacher',
            'surname' => 'Rajabov',
            'photo' => 'default.jpg',
            'phone' => '+998991111111',
            'passport' => 'KA1111111',
            'birth' => '21.06.2002',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('11111111'),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Student',
            'surname' => 'Rajabov',
            'photo' => 'default.jpg',
            'phone' => '+998991111111',
            'passport' => 'KA1111111',
            'birth' => '21.06.2002',
            'email' => 'student@gmail.com',
            'password' => Hash::make('11111111'),
            'role_id' => 3,
        ]);
    }
}
