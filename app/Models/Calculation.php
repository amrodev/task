<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $table = 'calculations';
    protected $fillable = ['argument1', 'argument2', 'average', 'area', 'squared_area'];
}
