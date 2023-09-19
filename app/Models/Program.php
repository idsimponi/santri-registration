<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = ['cabang_id', 'name', 'quota'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
