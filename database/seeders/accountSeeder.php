<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        accounts::create(
            [
                'title' => "Test Account 1",
                'type' => "PKR",
            ]
        );

        accounts::create(
            [
                'title' => "Test Account 2",
                'type' => "Dollar",
                
            ]
        );
    }
}
