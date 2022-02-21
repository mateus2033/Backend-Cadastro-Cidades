<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','cpf','state','city','state_id'];


    public function state()
    {
        return $this->belongsTo(States::class);
    }


}
