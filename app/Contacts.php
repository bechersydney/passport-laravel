<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $fillable = ['name','phone_number'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
