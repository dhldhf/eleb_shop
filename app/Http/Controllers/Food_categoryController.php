<?php

namespace App\Http\Controllers;

use App\Food_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Food_categoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    public function index()
    {
       $shop_id =  Auth::user()->information_id;
        $food_categories = Food_category::where('shop_id', '=', $shop_id)->paginate(3);
//        var_dump($food_categories);die;
//        $food_categories = Food_category::paginate();
        return view('food_categories.index',compact('food_categories'));
    }

    public function create()
    {
        return view('food_categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'required',
            'description'=>'required',
        ],
        [
            'name.required'=>'食品名称不能为空',
            'description.required'=>'描述不能为空',
        ]
        );
        $shop_id = Auth::user()->information_id;
        $name = $request->name;
        $food_categories = DB::select ("select count(*) as num from `food_categories` where shop_id ={$shop_id} and `name`='{$name}'");
//        var_dump($food_categories[0]->num);die;
        if ($food_categories[0]->num == 0){
            Food_category::create(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'shop_id'=>Auth::user()->id,
                ]
            );
        }else{
            session()->flash('danger','你的店铺已有该分类');
            return redirect()->route('food_category.create');
        }
        session()->flash('success','添加成功');
        return redirect()->route('food_category.index');
    }

    public function edit(Food_category $food_category)
    {
        return view('food_categories.edit',compact('food_category'));
    }

    public function update(Request $request,Food_category $food_category)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'description'=>'required',
            ],
            [
                'name.required'=>'食品名称不能为空',
                'description.required'=>'描述不能为空',
            ]
        );
        $shop_id = Auth::user()->information_id;
        $name = $request->name;
        $food_categories = DB::select ("select count(*) as num from `food_categories` where shop_id ={$shop_id} and `name`='{$name}'");
        if ($food_categories[0]->num == 0){
            $food_category->update(
                [
                    'name'=>$request->name,
                    'description'=>$request->description,
                ]
            );
        }else{
            session()->flash('danger','你的店铺已有该分类');
            return redirect()->route('food_category.edit',compact('food_category'));
        }
        session()->flash('success','修改成功');
        return redirect()->route('food_category.index');
    }

    public function destroy(Food_category $food_category)
    {
        $food_category->delete();
    }
}
