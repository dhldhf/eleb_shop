<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function index()
    {
//        var_dump(Auth::user()->information_id);die;
        $orders = Order::where([['shop_id','=',Auth::user()->information_id],['order_status','!=','-1']])->paginate(5);
        return view('orders.index',compact('orders'));
        }

    public function show(Order $order)
    {
        return view('orders.show',compact('order'));
    }

    public function edit(Order $order)
    {
        $order->update(
            [
                'order_status'=>-1,
            ]
        );
        return redirect()->route('orders.index');
    }

    public function ship(Order $order)
    {
//        dd($order->shop_name);die;
        $tel = $order->tel;
        $name = $order->shop_name;
//        dd($tel);
        $order->update(
            [
                'order_status'=>2,
            ]
        );
        $this->sms($tel,$name);
        return redirect()->route('orders.index');
    }
    public function sms($tel,$name)
    {
        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIW8ca7wm9wjSX";
        $accessKeySecret = "RCmTzXIhfViT4Pssk1qJOfGD1DuMNr";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "朝石锅拌饭";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_134140454";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
//        $code =  mt_rand(100000,999999);
        $params['TemplateParam'] = Array (
            "name" =>$name,
//        "product" => "阿里通信"
        );
        //  Redis::setex('code'.$tel,600,$code);
//        dd(Redis::get('code'.$request->tel));
        // fixme 可选: 设置发送短信流水号
//    $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//    $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \App\Sms();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );

//        dd($content);
        if ($content->Message == 'OK'){
           return true;
        }else{
            echo'{
        "status":"false",
        "message":"短信发送失败,请稍后试试"
        }';
        }
    }
    public function today(Request $request)
    {
        $date = date("Y-m-d");
        $last_date =date("Y-m-d 23:59:59");
        $month = date('Y-m-01');
        $month1 = date('Y-m-t 23:59:59');
        $information_id = Auth::user()->information_id;
        $orders = DB::select("select count(*) as num from `orders` WHERE order_birth_time BETWEEN '$date' AND '$last_date' AND shop_id={$information_id} AND order_status != -1");

        $orders_month = DB::select("select count(*) as num from `orders` WHERE order_birth_time BETWEEN '$month' AND '$month1' AND shop_id={$information_id} AND order_status != -1");

        $orders_all = DB::select("select count(*) as num from `orders` WHERE shop_id={$information_id}");
        $juti_date = $request->order_birth_time;
        $last_date = $request->order_birth_time1;
        $information_id = Auth::user()->information_id;
        if ($last_date){
            $juti_orders = DB::select("select count(*) as num from `orders` WHERE order_birth_time BETWEEN '$juti_date' AND '$last_date' AND shop_id={$information_id} AND order_status != -1");
            $juti_num = $juti_orders[0]->num;
        }else{
            $last_date_end = $juti_date.' 23:59:59';
            $juti_orders = DB::select("select count(*) as num from `orders` WHERE order_birth_time BETWEEN '$juti_date' AND '$last_date_end' AND shop_id={$information_id} AND order_status != -1");
            $juti_num = $juti_orders[0]->num;
        }
        $all = $orders_all[0]->num;
        $num1 = $orders_month[0]->num;
        $num = $orders[0]->num;
        return view('orders.today',['num'=>$num,'num1'=>$num1,'all'=>$all,'juti_num'=>$juti_num]);
    }
}
