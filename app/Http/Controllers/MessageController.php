<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Role;
use App\DraftMsg;
use DB;
use Carbon\Carbon;
use File;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class MessageController extends Controller
{



    public function appInbox(){
        $query=Auth::user()->email;

        $messages=Message::select('*')->where('msg_receiver',Auth::user()->email)
        ->orWhere('cc',Auth::user()->email)
        ->orderBy('created_at','DESC')
        ->simplePaginate(12);



// return $messages;
$totalUnseen=Message::where(function ($query) {
    $query->where('msg_receiver',Auth::user()->email)
          ->orWhere('cc',Auth::user()->email);
})->where('notification_status','Unseen')->count();

        $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
        $msg_received=Message::onlyTrashed()->where(function ($query) {
            $query->where('msg_receiver',Auth::user()->email)
                  ->orWhere('cc',Auth::user()->email);})->count();

        $totalTrashed = $msg_send+$msg_received;
        $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();


    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


        return view('back-end.message.app-inbox',[
        'messages'=>$messages,
        'totalUnseen'=>$totalUnseen,
        'totalTrashed'=>$totalTrashed,
        'totalDraft'=>$totalDraft,
        'totalFavMessages'=>$totalFavMessages,
        'page'=>'inbox',
        ]);
    }
    public function appCompose(){
    	return view('back-end.message.app-compose');
    }
    public function sendMessage(Request $request){
        $this->validate($request, [
            'msg_receiver' => 'required|max:40|min:8',
            'msg' => 'required|min:2',
        ]);
        $msg=$request->msg;
        $subject=$request->subject;
        $receverId=$request->msg_receiver;
        $authUser=Auth::user()->name;

        if($request->btnSendMsg){
        $message=New Message();
        $message->msg_sender=Auth::user()->email;
        $message->subject=$request->subject;
        $message->cc=$request->cc;
        $message->msg=$request->msg;
        $message->starred=0;
        $message->notification_status='Unseen';
        $message->msg_receiver=$request->msg_receiver;


        // Mail::send('back-end.mail.msg-mail', array(
        //     'name' => Auth::user()->name,
        //     'msg' => $request->msg), function ($message) use ($receverId, $subject) {
        //     $message->from('newshatbd@gmail.com', 'Newshutbd');
        //     $message->to($receverId, $subject)->subject($subject);
        // });

        $message->save();
        activityLog('Mail Send.');
        return redirect()->back()->with('message','Message Send Succefully');

    }else{
        $message=New DraftMsg();
        $message->msg_sender=Auth::user()->email;
        $message->subject=$request->subject;
        $message->cc=$request->cc;
        $message->msg=$request->msg;
        $message->starred=0;
        $message->msg_receiver=$request->msg_receiver;
        $message->save();
        activityLog('MAil Save to draft.');
        return redirect()->back()->with('message','Message Save on draft Succefully');
    }
    }
    public function msgDetails($id){
    // return $id;

    $message=Message::withTrashed()->find($id);
    if($message->msg_sender != Auth::user()->email){
    $message->notification_status='Seen';
    }
    $message->save();

    $totalUnseen=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('notification_status','Unseen')->count();

    $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
    $msg_received=Message::onlyTrashed()->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->count();
    $totalTrashed = $msg_send+$msg_received;
    $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


return view('back-end.message.msg-details',[
    'message'=>$message,
    'totalUnseen'=>$totalUnseen,
    'totalTrashed'=>$totalTrashed,
    'totalDraft'=>$totalDraft,
    'totalFavMessages'=>$totalFavMessages,
    ]);
    }

public function viewSendMessages(){
    $messages=Message::select('*')->where('msg_sender',Auth::user()->email)
    ->orderBy('created_at','DESC')
    ->simplePaginate(12);

    $totalUnseen=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('notification_status','Unseen')->count();

    $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
    $msg_received=Message::onlyTrashed()->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->count();
    $totalTrashed = $msg_send+$msg_received;

    $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


    return view('back-end.message.app-inbox',[
    'messages'=>$messages,
    'totalUnseen'=>$totalUnseen,
    'totalTrashed'=>$totalTrashed,
    'totalDraft'=>$totalDraft,
    'totalFavMessages'=>$totalFavMessages,
    'page'=>'Send Messages',
    ]);
}







public function draftMessages(){
    $message=DraftMsg::select('*')->where('msg_sender',Auth::user()->email)->get();

    $totalUnseen=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('notification_status','Unseen')->count();


    $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
    $msg_received=Message::onlyTrashed()->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->count();
    $totalTrashed = $msg_send+$msg_received;
    $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


    return view('back-end.message.app-draft-msg',[
        'messages'=>$message,
        'totalUnseen'=>$totalUnseen,
        'totalTrashed'=>$totalTrashed,
        'totalDraft'=>$totalDraft,
        'totalFavMessages'=>$totalFavMessages,
        ]);
}

public function draftMessagesDetails($id){
    $message=DraftMsg::find($id);
    return view('back-end.message.app-compose-draft-msg',[
        'message'=>$message,
    ]);

}










public function deleteMessages($id){
    Message::find($id)->delete();
    return redirect()->back()->with('message','Your Message is successfully deleted');
}

public function trashedMsg(){
    $msg_send=Message::onlyTrashed()->select('*')->where('msg_sender',Auth::user()->email)->get();
    $msg_received=Message::onlyTrashed()->select('*')->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->get();

    $merged = collect($msg_send)->merge($msg_received);
    $mergedSort = $merged->sortBy('created_at');


    // return $msg_received;

    $totalUnseen=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('notification_status','Unseen')->count();

    $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
    $msg_received=Message::onlyTrashed()->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->count();
    $totalTrashed = $msg_send+$msg_received;
    // return $totalTrashed;
    $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


    return view('back-end.message.app-trash-msg',[
    'messages'=>$mergedSort,
    'totalUnseen'=>$totalUnseen,
    'totalTrashed'=>$totalTrashed,
    'totalDraft'=>$totalDraft,
    'totalFavMessages'=>$totalFavMessages,
    ]);
}

public function trashedMsgPermanentDelete($id){
    Message::onlyTrashed()->find($id)->forceDelete();

    return redirect()->back()->with('message','Your Message is successfully deleted');
}


public function restoreTrashedMessage($id){
// return $id;
$trastedMsg=Message::onlyTrashed()->select('*')->where('id',$id)->restore();
return redirect()->back()->with('mesage','Message Restore Successfully');
}


public function addMessageToFavourite($id){

    $query=Auth::user()->email;

    $message=Message::find($id);

    if($message->starred==0){
    $message->starred=1;
    }else if($message->starred==1){
        $message->starred=0;
    }
    $message->save();
    return redirect()->back()->with('mesage','Message Add to Favorite List');

}
public function favouriteMessages(){


    $messages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->simplePaginate(12);


    $totalUnseen=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('notification_status','Unseen')->count();

    $msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
    $msg_received=Message::onlyTrashed()->where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);})->count();

    $totalTrashed = $msg_send+$msg_received;
    $totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

    $totalFavMessages=Message::where(function ($query) {
        $query->where('msg_receiver',Auth::user()->email)
              ->orWhere('cc',Auth::user()->email);
    })->where('starred',1)->count();


    return view('back-end.message.app-inbox',[
    'messages'=>$messages,
    'totalUnseen'=>$totalUnseen,
    'totalTrashed'=>$totalTrashed,
    'totalDraft'=>$totalDraft,
    'totalFavMessages'=>$totalFavMessages,
    'page'=>'Starrd Message',
    ]);

    // return view('back-end.message.app-msg-starred');
}

public function searchMail(Request $request){
// return $request;

$messages=Message::where(function ($query) {
    $query->where('msg_receiver',Auth::user()->email)
          ->orWhere('cc',Auth::user()->email);
})->where('subject', 'like', '%'.$request->search_query.'%')->simplePaginate(12);





$totalUnseen=Message::where(function ($query) {
    $query->where('msg_receiver',Auth::user()->email)
          ->orWhere('cc',Auth::user()->email);
})->where('notification_status','Unseen')->count();

$msg_send=Message::onlyTrashed()->where('msg_sender',Auth::user()->email)->count();
$msg_received=Message::onlyTrashed()->where(function ($query) {
    $query->where('msg_receiver',Auth::user()->email)
          ->orWhere('cc',Auth::user()->email);})->count();

$totalTrashed = $msg_send+$msg_received;
$totalDraft=DraftMsg::where('msg_sender',Auth::user()->email)->count();

$totalFavMessages=Message::where(function ($query) {
    $query->where('msg_receiver',Auth::user()->email)
          ->orWhere('cc',Auth::user()->email);
})->where('starred',1)->count();


return view('back-end.message.app-inbox',[
'messages'=>$messages,
'totalUnseen'=>$totalUnseen,
'totalTrashed'=>$totalTrashed,
'totalDraft'=>$totalDraft,
'totalFavMessages'=>$totalFavMessages,
'page'=>$request->search_from,
]);


}










// public function destroy($id)
//     {
//     	DB::table("products")->delete($id);
//     	return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
//     }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        // Message::find($id)->delete();
        $ids = $request->ids;
        // dd($ids);
        Message::whereIn('id',explode(",",$ids))->delete();
        activityLog('Delete Inbox Messages.');
        return response()->json(['success'=>"Message Deleted successfully."]);
    }

    public function deleteAllDraft(Request $request)
    {
        // Message::find($id)->delete();
        $ids = $request->ids;
        // dd($ids);
        DraftMsg::whereIn('id',explode(",",$ids))->delete();
        activityLog('Delete all draft messages.');
        return response()->json(['success'=>"Message Deleted successfully."]);
    }

    public function deleteAllTrashedMail(Request $request)
    {
        $ids = $request->ids;
        Message::onlyTrashed()->whereIn('id',explode(",",$ids))->forceDelete();
        activityLog('Delete all trash messages.');
        return response()->json(['success'=>"Message Deleted successfully."]);
    }

    public function restoreAllTrashedMail(Request $request)
    {
        $ids = $request->ids;
        Message::onlyTrashed()->whereIn('id',explode(",",$ids))->restore();
        activityLog('Restore trashed message');
        return response()->json(['success'=>"Message Restore successfully."]);
    }
    public function readAllMessage(Request $request)
    {
        $ids = $request->ids;
foreach($ids as $id){

            $message=Message::withTrashed()->find($id);
            $message->notification_status='Seen';
            $message->save();


         }
         activityLog('Read all messages.');
        // return response()->json(['success'=>$ids]);
        return response()->json(['success'=>"All Message Seen successfully."]);
    }
    public function unreadAllMessage(Request $request)
    {
        $ids = $request->ids;
foreach($ids as $id){

            $message=Message::withTrashed()->find($id);
            $message->notification_status='Unseen';
            $message->save();


         }
         activityLog('Unread all messages.');
        // return response()->json(['success'=>$ids]);
        return response()->json(['success'=>"All Message Seen successfully."]);
    }



}
