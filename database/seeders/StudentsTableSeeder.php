<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['id' => 12100396, 'name' => 'eslam hesham', 'email' => 'eslam@gmail.com', 'password' => bcrypt('eslam')],
            ['id' => 12100565, 'name' => 'mahmoud mohammed', 'email' => 'mahmoud@gmail.com', 'password' => bcrypt('mahmoud')],
            ['id' => 12100582, 'name' => 'abdelrahman mamdouh', 'email' => 'abdo@gmail.com', 'password' => bcrypt('abdo')],
        ];
        Student::insert($students);
    }
}
