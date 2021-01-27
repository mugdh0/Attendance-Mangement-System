<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\ActivityLog;

class DepartmentController extends Controller
{
    public function addNewDepartment(Request $request){
    	// return $request;
    $this->validate($request, [
        'dept_name' => 'required|max:30|min:2',
    ]);

$obj_dept=new Department();
$obj_dept->dept_name=$request->dept_name;
$obj_dept->dept_head=$request->dept_head;
$obj_dept->short_description=$request->short_description;
$obj_dept->save();

activityLog('Add new department info');

return redirect()->back()->with('message','Department Added Successfully');

    }

    public function deleteDept($id,$name){
        Department::find($id)->delete();
        
        activityLog('Delete Department Info');
    	return redirect()->back()->with('message','Department Successfully Deleted.');
    }

    public function editDept(Request $request){
    	    $this->validate($request, [
        'dept_name' => 'required|max:30|min:2',
    ]);
    	$obj_dept=Department::find($request->dept_id);
		$obj_dept->dept_name=$request->dept_name;
		$obj_dept->dept_head=$request->dept_head;
		$obj_dept->short_description=$request->short_description;
        $obj_dept->save();
        
        activityLog('Edit Department Info');

    	return redirect()->back()->with('message','Department Info Update Successfully.');
    }
}
