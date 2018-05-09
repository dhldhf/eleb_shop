@extends('layout.default')
@section('title','食品列表')
@section('content')
    <table class="table table-bordered" id="foods">
        <tr>
            <th>ID</th>
            <th>食品图片</th>
            <th>食品名称</th>
            <th>食品价格</th>
            <th>食品描述</th>
            <th>食品提示</th>
            <th>所属食品分类</th>
            <th>操作</th>
        </tr>
        @foreach($foods as $food)
            <tr data-id="{{ $food->goods_id }}">
                <td>{{$food->goods_id}}</td>
                <td><img src="{{ $food->goods_img }}" alt="" width="100px" height="100px"></td>
                <td>{{$food->goods_name}}</td>
                <td>{{$food->goods_price}}</td>
                <td>{{$food->description}}</td>
                <td>{{$food->tips}}</td>
                <td>{{$food->food_category->name}}</td>
                <td>
                    <a href="{{ route('foods.edit',compact('food')) }}" class="btn btn-sm btn-warning">编辑</a>
                    <button class="btn btn-danger">删除</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div>{{ $foods->links() }}</div>
    <a href="{{ route('foods.create') }}" class="btn btn-lg btn-info">添加食品</a>
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            $("#foods .btn-danger").on('click',function () {
                if(confirm('是否确认删除?')){
                    var tr = $(this).closest('tr');
                    var id = tr.attr('data-id');
                    $.ajax({
                        type: "DELETE",
                        url: "foods/"+id,
                        data: "_token={{ csrf_token() }}",
                        success: function(msg){
                            tr.fadeOut();
                        }
                    });
                }
            });
        });
    </script>
@stop
