<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
//        dd($request->file('file'));
        $img = $request->file('file')->store('public/foods');

        $client = App::make('aliyun-oss');
        try{
            $client->uploadFile(getenv('OSS_BUCKET'), $img, Storage_path('app/'.$img));
//            echo '上传成功';
//            var_dump($img);die;
            $fileName = 'https://laravel-eleb-shop.oss-cn-beijing.aliyuncs.com/'.$img;
            return ['url'=>$fileName];
        } catch(\OSS\Core\OssException $e) {
            echo "上传失败";
            printf($e->getMessage() . "\n");
        }

    }
}
