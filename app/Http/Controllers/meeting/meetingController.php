<?php

namespace App\Http\Controllers\meeting;
use App\Meeting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingConfirmation;

class meetingController extends Controller
{
    public function MeetingCreate(){

        return view('meeting/meetingCreate');

    }

    public function MeetingStore(Request $request){
         
        $this ->validate($request,[
            'title'      => 'required',                 //input validations
            'date'       => 'required',
            'startTime'  => 'required',
            'endTime'    => 'required',
            'status'     => 'required',
        ]);


        $meeting=new Meeting;

        $meeting->title       = $request-> input('title');          //store in db
        $meeting->date        = $request-> input('date');
        $meeting->startTime   = $request-> input('startTime');
        $meeting->endTime     = $request-> input('endTime');
        $meeting->description = $request-> input('description');
        $meeting->invitees    = $request-> input('invitees');
        $meeting->status      = $request-> input('status');

        $meeting->save();

        $meeting=Meeting::all();
        return redirect()->back()->with('message','Meeting Created Successfully.'); 

    }

    public function MeetingDelete($id){
    
        $a = Meeting::find($id);
        $a->delete();
        return redirect()->back()->with('message','Meeting Deleted Successfully.');

    }


    public function MeetingUpdate($id){

        $meeting = Meeting::find($id);

        return view('meeting/meetingUpdate')->with('meeting',$meeting);
           
    }


    public function MeetingUpdateSave(Request $request,$id){
        
        /*$this ->validate($request,[
            'title'      => 'required',
            'date'       => 'required',
            'startTime'  => 'required',
            'endTime'    => 'required',
            'status'     => 'required',
        ]);*/

        $meeting = Meeting::find($id);

        $meeting->title       = $request-> input('title');
        $meeting->date        = $request-> input('date');
        $meeting->startTime   = $request-> input('startTime');
        $meeting->endTime     = $request-> input('endTime');
        $meeting->description = $request-> input('description');
        $meeting->invitees    = $request-> input('invitees');
        $meeting->status      = $request-> input('status');
        
        $meeting->save();
        $data = Meeting::all();

        //return redirect('/meeting')->with('meeting',$data);

        return redirect()->back()->with('message','Meeting Updated Successfully.');

    }

    public function MeetingViewMail($id)
    {

       $meeting = Meeting::find($id);

       $date = '2018-12-12 at 08:00:00 to 09:00:00.';
             
       Mail::to($id)->send(new MeetingConfirmation($date));
       
       return redirect()->back()->with('message','Email sent successfully.');
       //return 'Email has been sent successfully';
    }      
 
 
}
