@extends('layout.default')
@section('title','食品分类列表')
@section('content')
    <table class="table table-bordered" id="food_categories">
        <tr>
            <th>ID</th>
            <th>食品分类名称</th>
            <th>食品分类描述</th>
            <th>操作</th>
        </tr>
        @foreach($food_categories as $food_category)
            <tr data-id="{{ $food_category->id }}">
                <td>{{$food_category->id}}</td>
                <td>{{$food_category->name}}</td>
                <td>{{$food_category->description}}</td>
                <td>
                    <a href="{{ route('food_category.edit',['food_category'=>$food_category]) }}" class="btn btn-sm btn-warning">编辑</a>
                    <button class="btn btn-danger">删除</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div>{{ $food_categories->links() }}</div>
    <a href="{{ route('food_category.create') }}" class="btn btn-lg btn-info">添加分类食品</a>
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            $("#food_categories .btn-danger").on('click',function () {
                if(confirm('是否确认删除?')){
                    var tr = $(this).closest('tr');
                    var id = tr.attr('data-id');
                    $.ajax({
                        type: "DELETE",
                        url: "food_category/"+id,
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
