@extends('layout.default')
@section('title','添加食品')
@section('content')
    <form method="post" action="{{route('foods.update',['food'=>$food])}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">食品名称</label>
            <input type="text" class="form-control" id="食品名称" placeholder="食品名称" name="food_name" value="{{ $food->food_name }}">
        </div>
        <div class="form-group">
            <label for="">描述</label>
            <input type="text" class="form-control" id="分类描述" placeholder="分类描述" name="description" value="{{ $food->description }}">
        </div>
        <div class="form-group">
            <label for="">价格</label>
            <input type="number" class="form-control" id="价格" placeholder="价格" name="food_price" value="{{ $food->food_price }}">
        </div>
        <div class="form-group">
            <label for="">商家图片</label>
            <img src="{{ $food->goods_img }}" alt="">
            <input type="file" name="goods_img">
        </div>
        <div class="form-group">
            <label for="">提示</label>
            <input type="text" class="form-control" id="提示" placeholder="提示" name="tips" value="{{$food->tips}}">
        </div>
        <div class="form-group">
            <label for="">所属分类食品</label>
            <select name="food_id" id="">
                @foreach($food_categories as $food_category)
                    <option value="{{ $food_category->id }}" {{ $food_category->id==$food->food_id?'selected':'$food_category->id' }}>{{ $food_category->name}}</option>
                @endforeach
            </select>
        </div>
        {{csrf_field()}}
        {{ method_field('put') }}
        <button type="submit" class="btn btn-primary btn-block">提交</button>
    </form>
@stop
