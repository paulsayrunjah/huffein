<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InwardRecord extends Model
{
    protected $fillable = [
        "currency", "amount", "status", "items", "date"
    ];
}
