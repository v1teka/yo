<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invObject extends Model
{
    protected $table = 'firsttable';
    protected $fillable = 
    [
        'invNum',
        'description',
        'room'
    ];
}
