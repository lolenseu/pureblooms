<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\User::create([
        'name' => 'Admin PureBlooms',
        'email' => 'admin@pureblooms.com',
        'password' => bcrypt('admin123'), // Default password
        'role' => 'admin',
    ]);
}
}
