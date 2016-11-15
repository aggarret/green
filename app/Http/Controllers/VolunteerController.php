<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\User;
use App\Interest;
use Session;
use App\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

class VolunteerController extends Controller
{
    public function __construct(){
    	$this->middleware('volunteer');
    }

    public function index(){
    	// return Auth::guard('volunner')->user();
    	return view('volunteer.dashboard');
    }

    /**
     * Create user dashboard.
     *
     * @param  
     * @return user
     */
    public function getDashboard()
    {
    $user = Auth::guard('volunteer')->user();
    $calendar_events = CalendarEvent::all();

        
        $userInterests = Auth::guard('volunteer')->user()->interests()->get();
        return view('/volunteer/dashboard', [
            'user' => $user,
            'userInterests' => $userInterests,
            
        ]);
    }

    /**
     * Create account.
     *
     * @param  
     * @return user
     */
    public function getAccount ()
    {
        return view('/volunteer/account', [
            'user' => Auth::guard('volunteer')->user(),
            'interests' => DB::table('interests')->get(),
            'interestsIds' => Auth::guard('volunteer')->user()->interests()->lists('id')->toArray(),
        ]);
    }

    public function postAccount (Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:120',
            'lastName' => 'alpha|max:120',
            'zipCode' => 'numeric|max:99999',
            'about' => 'string|max:5000',
        ]);
        //User info
        $user = Auth::guard('volunteer')->user();
        $user->firstName = $request['firstName'];
        $user->lastName = $request['lastName'];
        $user->zipCode = $request['zipCode'];
        $user->about = $request['about'];
        $user->update();

        //Interest IDs
        $interestIds = $request->input('interests');

        //Update Pivot table
        if (empty($interestIds))
            $user->interests()->detach();
        else $user->interests()->sync($interestIds);

        //Picture
        $file = $request->file('image');
        $filename = 'volunteer-' . $user->firstName . '-' . $user->id . '.jpg';
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }

        Session::flash('success', 'Successfully updated account');
        return redirect()->route('volunteer.dashboard');
    }


    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        //$file = Storage::get($filename);
        return new Response($file, 200);
    }

    /**
     * Register for an event.
     *
     * @param  
     * @return user
     */
    public function getEventRegister($id)
    {
        $volunteer = Auth::guard('volunteer')->user();
        
        //Check if user is already registered
        $exists = DB::table('calendar_event_volunteer')
        ->where('calendar_event_id', $id)
        ->where('volunteer_id', $volunteer->id)
        ->count() > 0;

        /*
         * Check if user is already registered for something
         */

        //Capture start and end time of unregistered event
        $unregistered_event = CalendarEvent::where('id', $id)->first();
        $unregistered_start_time = $unregistered_event->start;
        $unregistered_end_time = $unregistered_event->end;

        $count = 0;
        Log::info('volunteer: [' . $volunteer->id . '] Beginning check on currently registerd events');

        //Query user events to see if start/end time of unregistered event is within any other registrations
        $volunteer_registered_events = $volunteer->calendar_events->all();
        foreach($volunteer_registered_events as $registered_event)
        {
            Log::info('registered event ID: [' . $registered_event->id . ']');
            Log::info('unregistered event ID: [' . $unregistered_event->id . ']');

            $start_event_in_progress = $unregistered_start_time->between($registered_event->start, $registered_event->end);
            $end_event_in_progress = $unregistered_start_time->between($registered_event->start, $registered_event->end);

            Log::info('unregistered start time: [' . $unregistered_start_time . ']');
            Log::info('unregistered end time: [' . $unregistered_end_time . ']');
            Log::info('registered start time: [' . $registered_event->start . ']');
            Log::info('registered start time: [' . $registered_event->end . ']');
            
            //There is a conflict in registeration time with a previous registered event
            if ($start_event_in_progress || $end_event_in_progress)
            {
                Log::info('volunteer: [' . $volunteer->id . '] trying to register for an event: [' . $unregistered_event->id . ']. Already registered for event: [' . $registered_event->id . ']');
                $count += 1;
            } 
        }

        //User is already registerd for this event. unregisered user
        if ($exists)
        {
            $volunteer->calendar_events()->detach($id);
            Log::info('volunteer: [' . $volunteer->id . '] unregistered for event: [' . $unregistered_event->id . ']' . "\n\n");
            
            //num_registered_volunteers is unsigned.  This will prevent any weird errors
            if ($unregistered_event->num_registered_volunteers > 0)
            {
                $unregistered_event->num_registered_volunteers -= 1;
                $unregistered_event->update();
            }

            Session::flash('success', 'Successfully unregistered for event');
            return redirect()->back();
        }

        //Prevent user from registering for event in the past
        if (\Carbon\Carbon::now() > $unregistered_start_time)
        {
            $volunteer->calendar_events()->detach($id);
            Log::info('volunteer: [' . $volunteer->id . '] trying to register for event in teh past: [' . $unregistered_event->id . ']' . "\n\n");

            Session::flash('warning', 'Cannot register for event in the past');
            return redirect()->back();
        }



        //Event is already at capacity!
        if ($unregistered_event->num_registered_volunteers >= $unregistered_event->max_volunteer)
        {
            Log::info('unregistered event [' . $unregistered_event->id . '] is currently at capacity');
            Session::flash('warning', 'Event is at capacity.  Cannot register.');
            return redirect()->back();
        }


        
        //Pivot table does not contain entry. regisered user
        else
        {
            //user is not registered for any other event at this time
            if ($count == 0)  
            { 
                $volunteer->calendar_events()->attach($id);
                
                //Update event with the new number of registered volunteers
                $unregistered_event->num_registered_volunteers += 1;
                $unregistered_event->update();

                Log::info('volunteer: [' . $volunteer->id . '] now registered for event: [' . $unregistered_event->id . ']' . "\n\n");
                Session::flash('success', 'Successfully registered for event');
            }
            //User is trying to register for events at the same time
            else
            {
                Log::info('volunteer: [' . $volunteer->id . '] not allowed to register for event: [' . $unregistered_event->id . ']' . "\n\n");
                Session::flash('warning', 'Currently registered for an event at the same time');
            }
            return redirect()->back();
        }
    }


    public function addPhoto(Request $request){

        $file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('volunteers/photos', $name);

        return 'working on it';
    }

    public function destroy($id)
    {
        $volunteer_logged_in = Auth::guard('volunteer')->user();
        $volunteer = Volunteer::findOrFail($id);
        if ($volunteer_logged_in->id == $volunteer->id)
        {
            $volunteer->delete();
            return redirect()->route('volunteer.dashboard')->with('message', 'User deleted successfully.');
        }
        return redirect()->back();
    }
}
