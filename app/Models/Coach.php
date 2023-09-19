<?php

namespace App\Models;

use App\Models\Complaint;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Model
{
    use HasFactory , HasApiTokens;
    
    protected $fillable = [
        'name'                    ,
        'roles_id'                ,
        'gender'                  ,
        'weight'                  ,
        'height'                  ,   
        'birth_date'              ,
        'password'                ,
        'phone_number'            ,
        'email'                   ,
        'is_freez'                ,
        'rate'                    ,
        'is_active'               ,
        'wallet_balance'          ,
        'experience_certificate'  ,
    ];

    public function dailyValue()
    {
        return $this->morphOne(DailyValue::class, 'valueable');
    }

    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }
}
