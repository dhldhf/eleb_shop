<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function information()
    {
        return $this->belongsTo(Information::class,'shop_id');
    }
    protected $fillable = [
        'order_status',
    ];
}
