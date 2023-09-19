<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'             ,
        'verable_id'        ,
        'verable_type'      ,
        'vefrification_code',
        'is_confirmed'      ,
    ];

    public function verable()
    {
        return $this->morphTo();
    }
}
