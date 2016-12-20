<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Photo;
use App\CalendarEvent;
use DB;

class AboutPageController extends Controller
{
    public function getDashboard()
    {
        
		$Calendarevent = CalendarEvent::all();

		// Show photos that have an about page.
        $photos = DB::table('photos')->whereNotNUll('about_file')->get();


        
		// print_r($photos);
		// die();

        return view('about', compact('photos','Calendarevent' ));
    }

}
