@extends('layout.default')
@section('title','添加食品')
@section('content')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
    <form method="post" action="{{route('foods.store')}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">食品名称</label>
            <input type="text" class="form-control" id="食品名称" placeholder="食品名称" name="food_name" value="{{old('food_name')}}">
        </div>
        <div class="form-group">
            <input type="hidden" class="form-control" id="logo" placeholder="图片" name="img">
        </div>
        <div class="form-group">
            <label for="">描述</label>
            <input type="text" class="form-control" id="描述" placeholder="描述" name="description" value="{{old('description')}}">
        </div>
        <div class="form-group">
            <label for="">价格</label>
            <input type="number" class="form-control" id="价格" placeholder="价格" name="food_price" value="{{old('food_price')}}">
        </div>
        <div class="form-group">
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
                <div>
                    <img src="" alt="" id="img">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">提示</label>
            <input type="text" class="form-control" id="提示" placeholder="提示" name="tips" value="{{old('tips')}}">
        </div>
        <div class="form-group">
            <label for="">所属分类食品</label>
            <select name="food_id" id="">
                @foreach($food_categories as $food_category)
                <option value="{{ $food_category->id }}">{{ $food_category->name }}</option>
                @endforeach
            </select>
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary btn-block">提交</button>
    </form>
@stop
@section('js')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <script type="text/javascript">
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '/webuploader/Uploader.swf',

            // 文件接收服务端。
            server: '/upload',
            formData:{'_token':"{{ csrf_token() }}"},
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,response) {
//            $( '#'+file.id ).addClass('upload-state-done');
            var url = response.url;
//            console.log(url);
            $("#img").attr('src',url);
            //将图片地址赋值给输入框
            $("#logo").val(url);
        });
    </script>
    @stop