<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabang::create(['name' => 'IDN Jonggol Ikhwan']);
        Cabang::create(['name' => 'IDN Jonggol Akhwat']);
        Cabang::create(['name' => 'IDN Sentul']);
    }
}
