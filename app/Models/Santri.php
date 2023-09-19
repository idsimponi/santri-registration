<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 
        'password', 
        'nama_santri', 
        'jenis_kelamin', 
        'cabang_id', 
        'program_id', 
        'bukti_transfer'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
