<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Relations;
use App\Http\Requests;
use App\CalendarEvent;
use App\Organization;
use App\Volunteer;
use App\Interest;
use App\LeaderBoard;
use Session;
use Log;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Photo;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function getDashboard()
    {
        $user = Auth::guard('admin')->user();

        $photos = Photo::where('shared', true)->get();


        
        foreach ($photos as &$photo) {
        Log::info('test'.$photo->shared);
        }
        
        return view('admin.dashboard', compact('photos'));
    }
    public function AboutShare($id)
    {
        $photo = Photo::findorfail($id);   
        return view('admin.Share_About_Photos', compact('photo'));
    }
    public function AddPhoto($id)
    {
        
        $photo = Photo::findorfail($id);
        //Add the image name to the about file so it can be accessed on about page.
        $photo->about_file = $photo->image;



        //Add file name to colum named approved_by_admin
        $user = Auth::guard('admin')->user();
        $photo->admin_ok = $user->id;
        $photo->save();
        return back();

    }

    public function getPanelInterests(Request $request, $id = 'id', $direction = 'desc')
    {
        //flip-flop $direction between 'asc' and 'desc'
        ($direction == 'desc') ? $direction = 'asc' : $direction = 'desc';

        $user = Auth::guard('admin')->user();
        $interests = Interest::where(function($query) use ($request) {
            if ($term = $request->term) {
                $query->where('name', 'like', '%' . $term . '%');
            }
            else {
                $interests = Interest::all();
            }
        })
        ->orderBy($id, $direction)
        ->paginate(10);
        
        return view('admin.includes.interests', [
            'user' => $user,
            'interests' => $interests,
            'direction' => $direction]);
    }


    public function getPanelVolunteers(Request $request, $id = 'id', $direction = 'desc')
    {
        ($direction == 'desc') ? $direction = 'asc' : $direction = 'desc';
        
        $user = Auth::guard('admin')->user();
        $volunteers = Volunteer::where(function($query) use ($request) {
            if ($term = $request->term) {
                $query->orWhere('email', 'like', '%' . $term . '%');
                $query->orWhere('firstName', 'like', '%' . $term . '%');
                $query->orWhere('lastName', 'like', '%' . $term . '%');
                $query->orWhere('zipCode', 'like', '%' . $term . '%');
            }
            else {
                $volunteers = Volunteer::all();
            }
        })
        ->orderBy($id, $direction)
        ->paginate(10);
        
        return view('admin.includes.volunteers', [
            'user' => $user,
            'volunteers' => $volunteers,
            'direction' => $direction]);
    }


    public function getPanelOrganizations(Request $request, $id = 'id', $direction = 'asc')
    {
        ($direction == 'desc') ? $direction = 'asc' : $direction = 'desc';
        
        $user = Auth::guard('admin')->user();
        $organizations = Organization::where(function($query) use ($request) {
            if ($term = $request->term) {
                $query->orWhere('email', 'like', '%' . $term . '%');
                $query->orWhere('organization', 'like', '%' . $term . '%');
                $query->orWhere('firstName', 'like', '%' . $term . '%');
                $query->orWhere('lastName', 'like', '%' . $term . '%');
                $query->orWhere('zipCode', 'like', '%' . $term . '%');
            }
            else {
                $organizations = Organization::all();
            }
        })
        ->orderBy($id, $direction)
        ->paginate(10);
        
        return view('admin.includes.organizations', [
            'user' => $user,
            'organizations' => $organizations,
            'direction' => $direction]);
    }


    public function getPanelEvents(Request $request, $id = 'id', $direction = 'desc')
    {
        ($direction == 'desc') ? $direction = 'asc' : $direction = 'desc';

        $user = Auth::guard('admin')->user();
        $calendar_events = CalendarEvent::where(function($query) use ($request) {
            if ($term = $request->term) {
                $query->orWhere('title', 'like', '%' . $term . '%');
                $query->orWhere('start', 'like', '%' . $term . '%');
                $query->orWhere('end', 'like', '%' . $term . '%');
                $query->orWhere('organization_id', 'like', '%' . $term . '%');
            }
            else {
                $calendar_events = CalendarEvent::all();
            }
        })
        ->orderBy($id, $direction)
        ->paginate(10);
        
        return view('admin.includes.calendar_events', [
            'user' => $user,
            'calendar_events' => $calendar_events,
            'direction' => $direction]);
    }


    public function destroyVolunteer($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();

        Session::flash('success', 'Successfully deleted volunteer');
        return redirect()->back();
    }


    public function destroyOrganization($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        Session::flash('success', 'Successfully deleted organization');
        return redirect()->back();
    }


    public function destroyEvent($id)
    {
        $calendar_event = CalendarEvent::findOrFail($id);
        $calendar_event->delete();

        Session::flash('success', 'Successfully deleted event');
        return redirect()->back();
    }


    public function destroyInterest($id)
    {
        $interest = Interest::findOrFail($id);
        $interest->delete();

        Session::flash('success', 'Successfully deleted interest');
        return redirect()->back();
    }


    public function createInterest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        //Query Table to see if interest already exists
        $interest = Interest::where('name', $request->name)->first();
        
        //Create new entry
        if (empty($interest)) {
            $interest = \App\Interest::firstOrCreate(['name' => $request->name]);
            Log::info('New Interest: [' . $request->name . ']');
            Session::flash('success', 'Successfully created interest');
        }
        else Session::flash('warning', 'Interest already exists.  Not creating entry');

        return redirect()->back();
    }

    public function test()
    {
        //Query table for available zip codes.  only grab the top 3 leaders
        $leaders = LeaderBoard::where('date', \Carbon\Carbon::today())->orderBy('trackedHours', 'desc')->paginate(10);

        $volunteers = Volunteer::orderBy('trackedHours', 'desc')->paginate(3);
    
        return view('admin.includes.test', [
            'leaders' => $leaders,
            'volunteers' => $volunteers]);
    }
}