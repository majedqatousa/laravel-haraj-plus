<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tech;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\adminMessageNotification;
use App\Notifications\MailNotification;

use App\Mail\ContactMail;

use Illuminate\Support\Facades\Mail;

class TechController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Tech $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $techs = $this->model::with('replay','user')->where('parent_id',null)->OrWhere('user_id','!=', Auth::id())
        ->OrderBy('id','DESC')->get(); 
      
        return view('admin.techs.index', compact('techs'));
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
        //
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
        $this->model::where('id',$id)->delete();
        return response()->json(['success' => 'true']);
    }
    
    public function replayPage()
    {
       return view('admin.techs.create');
    }

    public function AdminReplay($id ,Request $request)
    {
    
        $tech =  Tech::with('replay')->where('id',$id)->first();
        if (!isset($tech->replay)) {
            Tech::create([
                'user_id'=>Auth::id(),
                'parent_id'=>$tech->id,
                'name'=>Auth::user()->name,
                'email'=>Auth::user()->email,
                'subject'=>$tech->subject,
                'message'=>$request['message']
                ]);

                $details=[
                    'type'=>'admin-message', 
                    'actionUrl'=>route('tech'),
                    'message'=>'تم الرد علي رسالة الدعم الفني'];
            
                    Notification::send($tech->user, new adminMessageNotification($details)); 
                 Notification::send($tech->user,new MailNotification(['line'=> $details['message'],'url'=>$details['actionUrl'],'url_text'=>'رسالة جديدة']));

            }
             else{
                 return response()->json(['fail'=>'عفوا هذا الطلب غير موجود في الموقع']); 
             }

 

         return response()->json(['success'=>'true']);


    } // end of replay admin tech
    
    public function AdminReplayContact(Request $request)
    {
    
    	$data = [
    	    'messageUser'  => $request['messageUser'],
    	    'messageAdmin' => $request['messageAdmin'],
    	    'subject'      => $request['subject'],
    	    'emailAdmin'   => Auth::user()->email,
    	    ];

        	Mail::to('infotes6@gmail.com')->send(new ContactMail($data));
        
         return response()->json(['success'=>'true']);


    } // end of replay admin tech    


}
