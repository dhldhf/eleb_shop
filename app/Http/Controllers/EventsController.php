<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{

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
}
