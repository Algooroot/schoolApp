<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use App\Models\AssignSubject;


class AssignSubjectController extends Controller
{
    public function ViewAssignSubject(){
        $data['allData'] = AssignSubject::select('class_id')->groupBy('class_id')->get();
        // $data['allData'] = AssignSubject::all();
        return view('backend.setup.assign_subject.view_assign_subject', $data);
    }


    public function AddAssignSubject(){
        $data['subjects'] = SchoolSubject::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.assign_subject.add_assign_subject',$data);
    }

    public function StoreAssignSubject(Request $request){
        $subjectcount = count($request->subject_id);

        if($subjectcount != NULL){
            for($i=0; $i<$subjectcount; $i++){
                $assign_subject = new AssignSubject();
                $assign_subject->class_id = $request->class_id;
                $assign_subject->subject_id = $request->subject_id[$i];
                $assign_subject->full_mark = $request->full_mark[$i];
                $assign_subject->pass_mark = $request->pass_mark[$i];
                $assign_subject->subjective_mark = $request->subjective_mark[$i];
                $assign_subject->save();
            }
        }

        $notification=array(
            'message'=>'Subject Assign insert  Successfully',
            'alert-type'=>'info',
        );

        return redirect()->route('assign.subject.view')->with($notification);
    }
}
