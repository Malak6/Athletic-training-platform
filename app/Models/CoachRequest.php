<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachRequest extends Model
{
    use HasFactory , SoftDeletes;

    protected $dates =['deleted_at'];

    protected $fillable = [
        'name'                    ,
        'gender'                  , 
        'weight'                  ,
        'height'                  ,    
        'birth_date'              ,
        'password'                ,
        'phone_number'            ,
        'email'                   ,
        'is_accepted'             ,
        'is_verified'             ,
        'experience_certificate'  ,
    ];

    public function email()
    {
        return $this->morphOne(EmailVer::class, 'verable');
    }
    
}



