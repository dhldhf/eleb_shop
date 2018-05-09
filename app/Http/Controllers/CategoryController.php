<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    public function index()
    {
        $categories = Category::paginate(3);
        return view('categories.index',compact('categories'));
        }

    public function create()
    {
        return view('categories.create');
        }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'logo'=>'required|image',
            ],
            [
                'name.required'=>'分类名称不能为空',
                'logo.required'=>'图片不能为空',
                'logo.image'=>'图片格式不正确',
            ]
        );
        $fileName = $request->file('logo')->store('public/categories');
        $file = url(Storage::url($fileName));
        Category::create(
            [
                'name'=>$request->name,
                'logo'=>$file,
            ]
        );
        session()->flash('success','添加成功');
        return redirect()->route('categories.index');
        }

    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
        }

    public function update(Request $request,Category $category)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'logo'=>'required|image',
            ],
            [
                'name.required'=>'分类名称不能为空',
                'logo.required'=>'图片不能为空',
                'logo.image'=>'图片格式不正确',
            ]
        );
        $fileName = $request->file('logo')->store('public/categories');
        $file = url(Storage::url($fileName));
        $category->update(
            [
                'name'=>$request->name,
                'logo'=>$file,
            ]
        );
        session()->flash('success','修改成功');
        return redirect()->route('categories.index');
        }

    public function destroy(Category $category)
    {
        $category->delete();
        }
}
