<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Organization;
use App\Volunteer;
use App\post;
use Illuminate\Support\Facades\Auth;

class postcontroller extends Controller
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
        $organization = Auth::guard('organization')->user();

        $volunteer = Auth::guard('volunteer')->user();

        $this->validate($request, [
            'title' => 'required|string|max:100',
            'conversation' => 'required|string|max:300',
            'users_post_id' => 'numeric'
        ]);

        $post = new post();
        $post->calendar_id      = (int)$request->input("calendar_id");
        $post->title            = $request->input("title");
        $post->conversation     = $request->input("conversation");
        if (Auth::guard('organization')->user()){
            $post->users_post_type = "App\Organization";
            $post->users_post_id = $organization->id;
            $post->save();
      } elseif (Auth::guard('volunteer')->user()){
            $post->users_post_type = "App\Volunteer";
            $post->users_post_id = $volunteer->id;
            $post->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $po = post::findOrFail($id);
        $po->delete();

        return back()->with('message', 'Item deleted successfully.');
    }
}
