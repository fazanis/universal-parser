<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    protected $fillable=[
        'name','url','title','text','photo','status','user_id'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
