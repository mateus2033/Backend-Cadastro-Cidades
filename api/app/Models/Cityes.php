<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cityes extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','iso_ddd','population','income_per_capital','state_id'];


    public function state()
    {
        return $this->belongsTo(States::class,'state_id');
    }



}
