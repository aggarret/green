<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Volunteer;
use App\Organization;
use App\Photo;
use App\Http\Requests;
use Image;
use Illuminate\Database\Eloquent\Relations;
use Session;
use Log;
use Storage;


class Photocotroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'file|required|mimes:jpeg,bmp,png'
            
        ]);
        $volunteer = Auth::guard('volunteer')->user();

        $organization = Auth::guard('organization')->user();

        $photo = new Photo();

        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $photo->shared =  (bool)$request['shared'];

        $photo->calendar_id =  (int)$request['calendar_id'];

        $photo->testimonial =  $request['testimonial'];

        


        
Log::info('test'.$photo->calendar_id);

            if(Auth::guard('volunteer')->user()){
               $volunteer = Volunteer::findorfail($volunteer->id);
               $location = public_path('volunteers\photos' . $filename);
               Image::make($file)->resize(200, 400)->save($location);
               $photo->image = $filename;
               var_dump(($volunteer));
               
               // dd(is_object($volunteer));
               $volunteer->photo()->save($photo);

               } 
            elseif (Auth::guard('organization')->user()){

            $organization = Organization::findorfail($organization->id);

            Session::flash('success', 'Photo Saved!');

            $location = public_path('organizations\photos' . $filename);

            Image::make($file)->resize(200, 400)->save($location);

            $photo->image = $filename;
            if ($photo->shared == 'TRUE') {
                $photo->shared_image = $filename;
                }

            $organization->Photo()->save($photo);
        }
               return back();


            
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::findorfail($id);   
        return view('Organization.PhotoEdit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $volunteer = Auth::guard('volunteer')->user();

        $organization = Auth::guard('organization')->user();

        $photo = Photo::findorfail($id);

        if ($request->hasFile('file')){

        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $oldfilename = $photo->image;
        }

        $photo->shared =  (bool)$request['shared'];

        
Log::info('test'.$photo->shared);

            if(Auth::guard('volunteer')->user()){
                
                if ($request->hasFile('file')){
               $location = public_path('volunteers\photos' . $filename);
               Image::make($file)->resize(200, 400)->save($location);
               $photo->image = $filename;
               }
               
               $photo->save();

               } 
            elseif (Auth::guard('organization')->user()){

            if ($request->hasFile('file')){


            $location = public_path('organizations\photos' . $filename);

            Image::make($file)->resize(200, 400)->save($location);
            Storage::delete('organizations\photos' . $oldfilename);


            $photo->image = $filename;
             }
            if ($photo->shared == 'TRUE') {
                $photo->shared_image = $filename;
                }
            else {
                $photo->shared_image == "";
            }
            
            $photo->save();
        }
               return redirect()->route('organization.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $volunteer = Auth::guard('volunteer')->user();

        $organization = Auth::guard('organization')->user();

        $photo = Photo::findorfail($id);

        if(Auth::guard('volunteer')->user()){
               $volunteer = Volunteer::findorfail($volunteer->id);
               // $volunteer->photo()->dissociate($photo);
               // $volunteer->save();

               Storage::delete('volunteers\photos' . $photo->image);
               $photo->delete();
           }
        if(Auth::guard('organization')->user()){
                $organization = Organization::findorfail($organization->id);
                // $organization->photo()->dissociate($photo);
                // $organization->save();
                
                Storage::delete('organizations\photos' . $photo->image);
                $photo->delete();
           }

        
            return back();
        

        

       
    }
}
