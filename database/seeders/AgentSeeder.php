<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Agent::insert([
            ['name' => 'John Smith', 'folder_count' => 45, 'profit' => 12500, 'trend' => 'up'],
            ['name' => 'Jane Doe', 'folder_count' => 33, 'profit' => 9800, 'trend' => 'down'],
            ['name' => 'Carlos Vega', 'folder_count' => 29, 'profit' => 11000, 'trend' => 'stable'],
        ]);
        
    }
}
