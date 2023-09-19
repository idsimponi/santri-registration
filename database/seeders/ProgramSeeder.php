<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabang1 = Cabang::where('name', 'IDN Jonggol Ikhwan')->first();
        $cabang2 = Cabang::where('name', 'IDN Jonggol Akhwat')->first();
        $cabang3 = Cabang::where('name', 'IDN Sentul')->first();

        Program::create(['cabang_id' => $cabang1->id, 'name' => 'SMP', 'quota' => 5]);
        Program::create(['cabang_id' => $cabang1->id, 'name' => 'SMK TKJ', 'quota' => 2]);
        Program::create(['cabang_id' => $cabang1->id, 'name' => 'SMK RPL', 'quota' => 2]);
        Program::create(['cabang_id' => $cabang1->id, 'name' => 'SMK DKV', 'quota' => 5]);

        Program::create(['cabang_id' => $cabang2->id, 'name' => 'SMP', 'quota' => 5]);
        Program::create(['cabang_id' => $cabang2->id, 'name' => 'SMK RPL', 'quota' => 5]);
        Program::create(['cabang_id' => $cabang2->id, 'name' => 'SMK DKV', 'quota' => 5]);

        Program::create(['cabang_id' => $cabang3->id, 'name' => 'SMP', 'quota' => 3]);
        Program::create(['cabang_id' => $cabang3->id, 'name' => 'SMK TKJ', 'quota' => 3]);
        Program::create(['cabang_id' => $cabang3->id, 'name' => 'SMK RPL', 'quota' => 3]);
        Program::create(['cabang_id' => $cabang3->id, 'name' => 'SMK DKV', 'quota' => 3]);
    }
}
