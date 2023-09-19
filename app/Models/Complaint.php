<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'complaintable_id',
        'complaintable_type' ,
        'text'
    ];

    public function complaintable()
    {
        return $this->morphTo();
    }


}

