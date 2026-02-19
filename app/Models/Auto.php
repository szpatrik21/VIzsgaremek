<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autok';

    protected $fillable = [
        'marka',
        'modell',
        'evjarat',
        'kilometerora',
        'ajtok_szama',
        'uzemanyag',
        'teljesitmeny',
        'kivitel',
        'allapot',
        'szemelyek_szama',
        'szin',
        'sebessegvalto',
        'hengerurtartalom',
        'raktaron',
        'ar',
        'kep',
        'kiemelt',

    ];

    public $timestamps = false;
}
