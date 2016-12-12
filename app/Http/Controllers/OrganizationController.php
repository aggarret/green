<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CalendarEvent;
use App\Volunteer;
use DB;
use Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Stripe\Stripe;

class OrganizationController extends Controller
{
    public function __construct(){
    	$this->middleware('organization');
    }

    public function index(){
    	// return Auth::guard('organization')->user();
    	return view('organization.dashboard');
    }

    public function getDashboard()
    {
        $staticEvent = \Calendar::event(
            'Today\'s Sample',
            true,
            Carbon::today()->setTime(0, 0),
            Carbon::today()->setTime(23, 59),
            null,
            [
                'color' => '#0F0',
                'url' => 'http://google.com',
            ]
        );


        $calendar_events = CalendarEvent::all();

        $calendar = \Calendar::addEvent($staticEvent)->addEvents($calendar_events);
        
        $Attending = DB::table('calendar_event_volunteer')->select('volunteer_id')->get();

        $volunteers = DB::table('volunteers')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('calendar_event_volunteer')
                      ->whereRaw('calendar_event_volunteer.volunteer_id = id');
            })
            ->get();

        $user = Auth::guard('organization')->user();

        return view('organization.dashboard', compact('user', 'volunteers','calendar_events', 'calendar'));
    }

    public function getAccount ()
    {
        return view('/organization/account', [
            'user' => Auth::guard('organization')->user(),
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
        $user = Auth::guard('organization')->user();
        $user->firstName = $request['firstName'];
        $user->lastName = $request['lastName'];
        $user->zipCode = $request['zipCode'];
        $user->about = $request['about'];
        $user->update();

        //Picture
        $file = $request->file('image');
        $filename = 'organization-' . $user->firstName . '-' . $user->id . '.jpg';
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }

        return redirect()->route('organization.dashboard');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        //$file = Storage::get($filename);
        return new Response($file, 200);
    }

    public function test()
    {
        return view('organization.test');
    }
    public function getPayment()
    {
        return view('organization.payment');
    }

    public function postPayment(Request $request)
    {
        Log::info('inside postPayment');
            
        $api_secret_key = getenv('STRIPE_SECRET_KEY');
        Log::info('api_secret_key' . $api_secret_key);
        Stripe::setApiKey($api_secret_key);
        try {
                $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Amount in cents
                "currency" => "usd",
                "source" => $request['stripeToken'],
                "description" => "Test"
                ));
        } catch(\Stripe\Error\Card $e) {
            return view('organization.payment', [
                'error' => $e->getMessage()
            ]);
        }
        Log::info('everything appears to be working');
        return redirect()->route('organization.test');
    }

}