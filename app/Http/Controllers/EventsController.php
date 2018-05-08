<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function index()
    {
        $business_id = Auth::user()->id;
        $business = DB::table('event_members')->where('member_id','=',$business_id)->get();
        $events_id = [];
        foreach ($business as $bu){
            $events_id[] = $bu->events_id;
        }
//        var_dump($business);die;
        $events = Events::paginate(5);
        return view('events.index',compact('events','events_id'));
    }

    public function show(Events $event)
    {
        $event_prizes = DB::table('event_prizes')->where('events_id','=',$event->id)->get();
        return view('events.show',compact('event','event_prizes'));
    }

    public function edit(Events $event)
    {
        $time = date('Y-m-d');
        if($time < $event->signup_start){
            session()->flash('warning','未到报名时间还不能报名');
            return redirect()->route('events.index');
        }
        if($time > $event->signup_end){
            session()->flash('warning','报名时间已截止,抱歉');
            return redirect()->route('events.index');
        }
        $businesses = DB::select("select count(*) as num from event_members WHERE events_id={$event->id}");
        $numer = $businesses[0]->num;
            if ($numer >= $event->signup_num){
                session()->flash('success','人数已超过限制,不能再报名下次请早');
                return redirect()->route('events.index');
            }
//        var_dump($numer);die;
        DB::table('event_members')->insert(
            ['events_id' => $event->id, 'member_id' => Auth::user()->id]
        );
        session()->flash('success','报名成功');
        return redirect()->route('events.index');
    }

    public function winning(Events $event)
    {
        $time = date('Y-m-d');
        if($time < $event->prize_date){
            session()->flash('warning','未到开奖时间还不能查看');
            return redirect()->route('events.index');
        }
        $event_prizes = DB::table('event_prizes')->where('events_id','=',$event->id)->get();
//        dd($event_prizes);
        foreach ($event_prizes as $event_prize){
            $businesses = DB::table('businesses')->where('id','=',$event_prize->member_id)->get();
//            dd($businesses);
            $event_prize->bu=$businesses;
        }

        return view('events.winning',compact('event_prizes'));

    }
}
