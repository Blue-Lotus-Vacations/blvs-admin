<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quote::insert([
            ['text' => 'Push harder than yesterday if you want a different tomorrow.'],
            ['text' => 'Success is no accident. It is hard work and perseverance.'],
        ]);
    }
}
