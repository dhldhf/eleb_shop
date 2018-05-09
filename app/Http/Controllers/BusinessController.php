<?php

namespace App\Http\Controllers;

use App\Business;
use App\Category;

use App\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [ 'create', 'store']
        ]);
    }
    public function index()
    {
       $businesses =  Business::paginate(3);
        return view('businesses.index',compact('businesses'));
    }
    public function create()
    {
        $categories = Category::all();
//        var_dump($categories);
        return view('businesses.create',compact('categories'));
        }

    public function store(Request $request)
    {
        $this->validate($request,
            [
            'name'=>'required',
            'logo'=>'required|image',
             'password'=>'required|min:3|confirmed',
             'captcha'=>'required|captcha',
            'phone'=>'required|min:11|max:12',
            'email'=>'required|email',
        ],
            [
            'name.required'=>'商家名称不能为空',
            'logo.required'=>'商家图片不能为空',
            'logo.image'=>'图片格式不正确',
            'password.required'=>'密码不能为空',
            'password.confirmed'=>'密码两次填写不一致',
            'password.min'=>'密码不能小于三位',
            'captcha.required'=>'验证码不能为空',
            'captcha.captcha'=>'验证码填写错误',
            'phone.min'=>'电话号码不能小于11位',
            'phone.max'=>'电话号码不能超过12位',
            'phone.required'=>'电话号码不能为空',
            'email.required'=>'邮箱不能为空',
            'email.email'=>'邮箱格式不正确',
            ]);
//        var_dump($request->brand,$request->bao);die;
        DB::transaction(function ()use($request){
        $information_id = Information::create(
            [
                'shop_name'=>$request->name,
                'brand'=>$request->brand,
                'bao'=>$request->bao,
                'on_time'=>$request->on_time,
                'zhun'=>$request->zhun,
                'fengniao'=>$request->fengniao,
                'piao'=>$request->piao,
            ]);
//        var_dump($information_id->id);die;
            $fileName = $request->file('logo')->store('public/businesses');
            $file = url(Storage::url($fileName));
        Business::create(
                [
                    'name'=>$request->name,
                    'logo'=>$file,
                    'phone'=>$request->phone,
                    'password'=>bcrypt($request->password),
                    'categories_id'=>$request->categories_id,
                    'information_id'=>$information_id->id,
                    'email'=>$request->email,
                ]
            );
        });

        session()->flash('success','注册成功');
        return redirect()->route('businesses.index');
        }
    public function edit(Business $business)
    {
            return view('businesses.edit',compact('business'));
        }

    public function update(Request $request,Business $business)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'logo'=>'required|image',
                'password'=>'required|min:3|confirmed',
                'phone'=>'required|min:11|max:12',
                'email'=>'required|email',
            ],
            [
                'name.required'=>'商家名称不能为空',
                'logo.required'=>'商家图片不能为空',
                'logo.image'=>'图片格式不正确',
                'password.required'=>'密码不能为空',
                'password.confirmed'=>'密码两次填写不一致',
                'password.min'=>'密码不能小于三位',
                'phone.min'=>'电话号码不能小于11位',
                'phone.max'=>'电话号码不能超过12位',
                'phone.required'=>'电话号码不能为空',
                'email.required'=>'邮箱不能为空',
                'email.email'=>'邮箱格式不正确',
            ]);
        $fileName = $request->file('logo')->store('public/businesses');
        $business->update(
            [
                'name'=>$request->name,
                'logo'=>$fileName,
                'phone'=>$request->phone,
                'password'=>bcrypt($request->password),
                'email'=>$request->email,
            ]
        );
        session()->flash('success','修改成功');
        return redirect()->route('businesses.index');
        }

    public function destroy(Business $business)
    {
        $business->delete();
        }

    public function pass(Business $business)
    {
        return view('businesses.pass',compact('business'));
    }

    public function add_pass(Request $request,Business $business)
    {
        $this->validate($request,
            [
                'name'=>'required',
                'old_password'=>'required',
                'password'=>'required|min:3|confirmed',
            ],
            [
                'name.required'=>'名称不能为空',
                'old_password.required'=>'旧密码不能为空',
                'password.required'=>'新密码不能为空',
                'password.min'=>'密码不能小于三位',
                'password.confirmed'=>'两次输入的密码不一致',
            ]);
//        dd(1);
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $business->update(
            [
                'password'=>bcrypt($request->password),
            ]);
        } else{
            session()->flash('danger','修改密码失败,旧密码填写错误');
            return redirect()->back();
        }
        session()->flash('success','修改成功');
        return redirect()->route('businesses.index');
    }
}
