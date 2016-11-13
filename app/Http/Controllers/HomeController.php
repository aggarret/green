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
        
        //need to grab the org names in the controller and pass into blade.  too hard to strip once inside blade
        $calendars = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->get();
        $orgs = [];
        foreach ($calendars as $calendar)
        {
           $orgs[] = utf8_encode($calendar->organization->organization);
        }
        Log::info($orgs);
        $orgs = json_encode($orgs);

        
        return view('home', [
            'calendar_events' => $calendar_events,
            'orgs' => $orgs
            ]);
    }

    public function test()
    {
        $calendar_events = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->get()->toJson();

        return view('test', [
            'calendar_events' => $calendar_events]);
    }
}
