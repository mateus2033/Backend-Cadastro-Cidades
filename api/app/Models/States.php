<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','initials','population'];


    public function city()
    {
        return $this->hasMany(Cityes::class,'state_id','id');
    }

    public function people()
    {
        return $this->hasMany(People::class,'state_id','id');
    }

}
