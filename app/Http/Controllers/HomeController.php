<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Organization;
use App\Volunteer;
use DB;
use Log;
use Session;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendar_events = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->get()->toJson();
        return view('home', [
            'calendar_events' => $calendar_events]);
    }

    public function test()
    {
        $calendar_events = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->get()->toJson();

        return view('test', [
            'calendar_events' => $calendar_events]);
    }
}
