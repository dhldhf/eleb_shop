<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food_category extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'shop_id', 'description', 'is_selected','type_accumulation',
    ];
}
