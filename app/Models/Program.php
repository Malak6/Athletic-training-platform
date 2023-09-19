<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'players_id',
        'coaches_id',
        'first_day',
        'second_day' ,
        'third_day' ,
        'fourth_day' , 
        'fifth_day' ,
        'sixth_day' ,  
        'seventh_day' ,
        'notes' ,
        'end_date' 
    ];
}
