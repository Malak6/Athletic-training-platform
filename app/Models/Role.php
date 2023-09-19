<?php

namespace App\Models;

use App\Models\Coach;
use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function players()
    {
        return $this->hasMany(Player::class , 'roles_id');
    }

    public function coaches()
    {
        return $this->hasMany(Coach::class , 'roles_id');
    }

}
