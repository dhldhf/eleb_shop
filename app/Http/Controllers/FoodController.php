<?php

namespace App\Http\Controllers;

use App\Food;
use App\Food_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $shop_id =  Auth::user()->information_id;
        $foods = Food::where('shop_id', '=', $shop_id)->paginate(3);
//        echo '<pre/>';
//        var_dump($foods);die;
       return view('foods.index',compact('foods'));
    }

    public function create()
    {
        $shop_id =  Auth::user()->information_id;
        $food_categories = DB::table('food_categories')->where('shop_id', '=', $shop_id)->get();
//        var_dump($food_categories);die;
        return view('foods.create',compact('food_categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'food_name'=>'required',
                'description'=>'required',
                'tips'=>'required',
                'img'=>'required',
                'food_price'=>'required',
                'food_id'=>'required',
            ],
            [
                'food_name.required'=>'食品名称不能为空',
                'description.required'=>'描述不能为空',
                'tips.required'=>'提示不能为空',
                'img.required'=>'图片不能为空',
                'food_price.required'=>'价格不能为空',
                'food_id.required'=>'所属分类食品不能为空',
            ]
        );
        $shop_id = Auth::user()->information_id;
        $food_name = $request->food_name;
        $food_id = $request->food_id;
        $foods = DB::select ("select count(*) as num from `foods` where shop_id={$shop_id} and food_id={$food_id} and `goods_name`='{$food_name}'");

        if ($foods[0]->num == 0){
            Food::create(
                [
                    'goods_name'=>$request->food_name,
                    'description'=>$request->description,
                    'tips'=>$request->tips,
                    'goods_img'=>$request->img,
                    'goods_price'=>$request->food_price,
                    'food_id'=>$request->food_id,
                    'shop_id'=>Auth::user()->information_id,
                ]
            );
        }else{
            session()->flash('danger','你的店铺该分类下已有该食品');
            return redirect()->route('foods.create');
        }
        session()->flash('success','添加成功');
        return redirect()->route('foods.index');
    }

    public function destroy(Food $food)
    {
        $food->delete();
    }

    public function edit(Food $food)
    {
        $shop_id =  Auth::user()->information_id;
        $food_categories = DB::table('food_categories')->where('shop_id', '=', $shop_id)->get();
        return view('foods.edit',compact('food','food_categories'));
    }

    public function update(Request $request,Food $food)
    {
        $this->validate($request,
            [
                'food_name'=>'required',
                'description'=>'required',
                'tips'=>'required',
                'goods_img'=>'required|image',
                'food_price'=>'required',
                'food_id'=>'required',
            ],
            [
                'food_name.required'=>'食品名称不能为空',
                'description.required'=>'描述不能为空',
                'tips.required'=>'提示不能为空',
                'goods_img.required'=>'图片不能为空',
                'goods_img.image'=>'图片格式不正确',
                'food_price.required'=>'价格不能为空',
                'food_id.required'=>'所属分类食品不能为空',
            ]
        );
        $fileName = $request->file('goods_img')->store('public/foods');
        $file = url(Storage::url($fileName));
//        var_dump($request->food_id);die;
        $food->update(
            [
                'food_name'=>$request->food_name,
                'description'=>$request->description,
                'tips'=>$request->tips,
                'goods_img'=>$file,
                'food_price'=>$request->food_price,
                'food_id'=>$request->food_id,
            ]
        );
        session()->flash('success','修改成功');
        return redirect()->route('foods.index');
    }

}
