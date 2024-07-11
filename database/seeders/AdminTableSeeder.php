<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin')],
            ['name' => 'hassan', 'email' => 'hassan@gmail.com', 'password' => bcrypt('hassan')],

        ];
        Admin::insert($admins);
    }
}
