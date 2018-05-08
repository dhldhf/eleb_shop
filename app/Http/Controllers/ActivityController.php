<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    public function index()
    {
        $time = time();
        $activities = Activity::where('end_time','>',"$time")->paginate(3);
        return view('activities.index',compact('activities'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        $time = strtotime($activity->end_time);
        $times = strtotime($activity->start_time);
        $tu = $time - $time;
//        dd($tu);
        return view('activities.show',compact('activity','$tu'));
    }
}
