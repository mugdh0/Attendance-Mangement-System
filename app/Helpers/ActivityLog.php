<?php
use App\ActivityLog;
use App\EmpActivityLog;
if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {

    }
    function ActivityLog($message){
        
            $obj_activitylog=new ActivityLog();
            $obj_activitylog->name=Auth::user()->name;
            $obj_activitylog->email=Auth::user()->email;
            $obj_activitylog->message=$message;
            $obj_activitylog->save();
        
    }
    function ActivityLogEmp($user_id,$changeBy,$message){
        
        $obj_activitylog=new EmpActivityLog();
        $obj_activitylog->user_id=$user_id;
        $obj_activitylog->change_by=$changeBy;
        $obj_activitylog->message=$message;
        $obj_activitylog->save();
    
}

    
}
