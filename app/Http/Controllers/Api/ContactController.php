<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contacts;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // view all contacts
        // $contact = Contacts::all();
        // view contact by user created

        $contact = request()->user()->contacts;
        return  ContactResource::collection($contact);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = $request->user()->contacts()->create($request->all());
        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contacts $contact)
    {
        return new ContactResource($contact);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacts $contact)
    {
        if($request->user()->id !== $contact->user_id){
            return response()->json(['status'=>'error', 'message'=>'UnAuthorized User'],401);
        }
        $contact->update($request->all());

        return new ContactResource($contact);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contacts $contact)
    {
        if($request->user()->id !== $contact->user_id){
            return response()->json(['status'=>'error', 'message'=>'UnAuthorized User'],401);
        }
        $contact = $contact->delete();
        return response()->json(null,200);
    }
}
