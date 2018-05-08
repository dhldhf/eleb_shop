@extends('layout.default')
@section('title','活动列表')
@section('content')
    <table class="table table-bordered" id="activities">
        <tr>
            <th>ID</th>
            <th>活动标题</th>
            <th>活动开启时间</th>
            <th>活动结束时间</th>
            <th>操作</th>
        </tr>
        @foreach($activities as $activity)
            <tr data-id="{{ $activity->id }}">
                <td>{{$activity->id}}</td>
                <td>{{ $activity->title }}</td>
                <td>{{date('Y-m-d',$activity->start_time)}}</td>
                <td>{{date('Y-m-d',$activity->end_time)}}</td>
                <td>
                    <a href="{{ route('activities.show',['activity'=>$activity]) }}" class="btn btn-sm btn-primary">活动详情</a>
                </td>
            </tr>
        @endforeach
    </table>
    <div>{{ $activities->links() }}</div>
@stop
