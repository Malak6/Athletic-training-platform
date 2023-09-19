<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Player extends Model
{
    use HasFactory , HasApiTokens;

    protected $fillable = [
        'name'                  ,
        'roles_id'              ,
        'physical_activities_id',
        'weight'                ,
        'height'                ,
        'gender'                ,
        'birth_date'            ,
        'phone_number'          ,
        'disease'               ,
        'password'              ,
        'email'                 ,
        'is_freez'              ,
        'wallet_balance'        ,
        'is_verified'           ,
    ];

    public function dailyValue()
    {
        return $this->morphOne(DailyValue::class, 'valueable');
    }

    public function email()
    {
        return $this->morphOne(EmailVer::class, 'verable');
    }

    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }
}
