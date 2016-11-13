<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Organization;
use App\post;
use App\Volunteer;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Log;
use Session;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
   public function guestindex()
    {
        $user = Auth::guard('organization')->User();
        $calendar_events = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->orderBy('id', 'desc')->paginate(10);

        return view('calendar_events.index', compact('calendar_events','user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $user = Auth::guard('organization')->User();
        $calendar_events = CalendarEvent::where('start', '>', \Carbon\Carbon::now())->orderBy('id', 'desc')->paginate(10);

        return view('calendar_events.index', compact('calendar_events','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('calendar_events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $org = Auth::guard('organization')->user();

        $this->validate($request, [
            'title' => 'required|string|max:127',
            'description' => 'string|max:511',
            'start' => 'required|date',
            'end' => 'required|date',
            'max_volunteer' => 'required|integer',
            'address_street' => 'required|string|max:127',
            'address_city' => 'required|string|max:63',
            'address_state' => 'required|string|max:31',
            'address_zip' => 'numeric|max:99999'
        ]);

        $calendar_event = new CalendarEvent();

        $calendar_event->title              = $request->input("title");
        $calendar_event->description        = $request->input("description");
        $calendar_event->start              = $request->input("start");
        $calendar_event->end                = $request->input("end");
        $calendar_event->max_volunteer      = $request->input("max_volunteer");
        $calendar_event->address_street     = $request->input("address_street");
        $calendar_event->address_city       = $request->input("address_city"); 
        $calendar_event->address_state      = $request->input("address_state"); 
        $calendar_event->address_zip        = $request->input("address_zip");
        $calendar_event->coord_lat          = $request->input("lat");
        $calendar_event->coord_lng          = $request->input("lng");
        $calendar_event->google_city        = $request->input("google_city");
        $calendar_event->google_county      = $request->input("google_county");

        

        $org->calendar()->save($calendar_event);

        Session::flash('success', 'Successfully created an event!');
        return response()->json(['responseText' => 'Success!'], 200);
        //return redirect()->route('calendar_events.index')->with('message', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $calendar_event = CalendarEvent::findOrFail($id);
        $post = post::all();
        $Org = organization::all();
        $Vol = $calendar_event->volunteers;

        return view('calendar_events.show', compact(['calendar_event', 'post','Org','Vol']));
    }

    public function guestshow($id)
    {
        $calendar_event = CalendarEvent::findOrFail($id);
        $organization = Auth::guard('organization')->user();
        $volunteer = Auth::guard('volunteer')->user();
        $post = $post = post::all();
        $Org = organization::all();
        $Vol = $calendar_event->volunteers;



        if ($volunteer)
        {
            $exists = DB::table('calendar_event_volunteer')
            ->where('calendar_event_id', $id)
            ->where('volunteer_id', $volunteer->id)
            ->count() > 0;

            return view('calendar_events.show', compact(['calendar_event', 'exists', 'post','Org','Vol', 'volunteer', 'organization']));
        }
        else return view('calendar_events.show',  compact(['calendar_event', 'post','Org','Vol','volunteer', 'organization']));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $calendar_event = CalendarEvent::findOrFail($id);

        return view('calendar_events.edit', compact('calendar_event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|alpha_num|max:120',
            'description' => 'alpha_num|max:500',
            'start' => 'required|date',
            'end' => 'required|date',
            'max_volunteer' => 'required|integer',
        ]);

        $calendar_event = CalendarEvent::findOrFail($id);

        $calendar_event->title            = $request->input("title");
        $calendar_event->description      = $request->input("description");
        $calendar_event->start            = $request->input("start");
        $calendar_event->end              = $request->input("end");
        $calendar_event->max_volunteer    = $request->input("max_volunteer");

        $calendar_event->save();

        return redirect()->route('calendar_events.index')->with('message', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $calendar_event = CalendarEvent::findOrFail($id);
        $calendar_event->delete();

        return redirect()->route('calendar_events.index')->with('message', 'Item deleted successfully.');
    }

}
