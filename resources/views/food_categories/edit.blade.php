@extends('layout.default')
@section('title','修改分类食品')
@section('content')
    <form method="post" action="{{route('food_category.update',['food_category'=>$food_category])}}">
        <div class="form-group">
            <label for="">食品分类名称</label>
            <input type="text" class="form-control" id="食品分类名称" placeholder="食品分类名称" name="name" value="{{ $food_category->name }}">
        </div>
        <div class="form-group">
            <label for="">分类描述</label>
            <input type="text" class="form-control" id="分类描述" placeholder="分类描述" name="description" value="{{ $food_category->description }}">
        </div>
        {{ method_field('put') }}
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary btn-block">提交</button>
    </form>
@stop
