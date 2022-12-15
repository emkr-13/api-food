<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    public $timestamps = FALSE;

    protected $fillable = [
        'jenis_komentar',
        'nama_makanan',
        'cacatan',
    ];
}
