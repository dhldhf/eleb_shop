@extends('layout.default')
@section('title','活动列表')
@section('content')
    <table class="table table-bordered">
        <tr>
            <th>活动名称</th>
            <th>详情</th>
            <th>报名开始时间</th>
            <th>报名结束时间</th>
            <th>开奖日期</th>
            <th>报名人数限制</th>
            <th>是否已开奖</th>
            <th>操作</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td>{{$event->title}}</td>
                <td>{{$event->content}}</td>
                <td>{{$event->signup_start}}</td>
                <td>{{$event->signup_end}}</td>
                <td>{{$event->prize_date}}</td>
                <td>{{$event->signup_num}}</td>
                <td>{{$event->is_prize==0?'未开奖':'已开奖'}}</td>
                <td>
                    <a href="{{ route('events.show',['event'=>$event]) }}" class="btn btn-success">查看活动及奖品</a>
                    <a href="{{ route('winning',['event'=>$event]) }}" class="btn btn-primary">查看活动中奖详情</a>
                    @if(!in_array($event->id,$events_id))
                    <a href="{{ route('events.edit',['event'=>$event])}}" class="btn btn-danger">报名</a>
                        @endif
                </td>
            </tr>
        @endforeach
    </table>
@stop
