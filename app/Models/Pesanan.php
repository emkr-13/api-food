<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    public $timestamps = FALSE;

    protected $fillable = [
        'nama',
        'harga',
        'total_pesanan',
        'note_pesanan',
    ];
}
