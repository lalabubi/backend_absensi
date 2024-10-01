<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    public $table = 'presensi';
    protected $guarded = ['id'];

    public $timestamps = false;
}
