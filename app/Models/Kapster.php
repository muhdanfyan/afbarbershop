<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kapster extends Model
{
    protected $table = 'kapster';

    protected $fillable = [
        'nama',
        'nik',
        'no_wa',
        'alamat',
        'foto'
    ];
}
