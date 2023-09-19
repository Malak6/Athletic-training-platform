<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'valueable_id'          ,
        'valueable_type'        ,
        'daily_water_need'      ,
        'daily_water_intake'    ,
        'daily_calorie_need'    ,
        'daily_calorie_intake'  ,
        'daily_carb_need'       ,
        'daily_carb_intake'     ,
        'daily_protein_need'    ,
        'daily_protein_intake'  ,
        'daily_fat_need'        ,
        'daily_fat_intake'      ,
        'daily_fibers_need'     , 
        'daily_fibers_intake'   ,
    ];

    
    public function valueable()
    {
        return $this->morphTo();
    }
}
