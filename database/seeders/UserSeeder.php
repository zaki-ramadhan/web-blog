<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Zaki Ramadhan',
            'username' => 'zakiramadhan',
            'email' => 'zakiram4dhan@gmail.com',
            'password' => Hash::make('zaki123'),
        ]);

        User::factory(4)->create();
    }
}
