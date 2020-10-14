<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    protected $fillable=[
        'name','url','title','text','photo','status','user_id'
    ];
}
