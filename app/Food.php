<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public $timestamps = false;
            
    protected $primaryKey='goods_id';
    protected $fillable = [
        'goods_name', 'goods_img', 'tips', 'satisfy_count', 'rating_count', 'description','goods_price', 'rating', 'month_sales', 'satisfy_rate', 'foods_code', 'high_or_now','food_id','shop_id',
    ];
    public function food_category()
    {
        return $this->belongsTo(Food_category::class,'food_id');
    }
}
