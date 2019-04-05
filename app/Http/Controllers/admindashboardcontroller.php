<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use stdClass;

class admindashboardcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admindashboard');
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
        //
    }

    public function t_dashboard()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $name = DB::table('users')->where('user_id',Session::get('user_id'))->pluck('name');
        $advising_count = DB::table('sections')->where('advisor_id',Session::get('user_id'))->where('session_id','!=',null)->count();
        $subject_count = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->count();
        return view('teacher.teacherdashboard')->with('advising_count',$advising_count)->with('subject_count',$subject_count)->with('active_session',$active_session)->with('name',$name);
    }
    public function s_dashboard()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
        $name = DB::table('users')->where('user_id',Session::get('user_id'))->pluck('name');
        $enrolled_for = DB::table('sessiondatas')->where('session_id',$active_session->id)
                        ->where('student_id',Session::get('user_id'))
                        ->where('pending',1)
                        ->count();
        $data['session'] = $active_session;
        $data['enrolled'] = $enrolled_for;
        $data['name'] = $name;
        return view('student.studentdashboard')->with('data',$data);
        }
        else
        {
            $name = DB::table('users')->where('user_id',Session::get('user_id'))->pluck('name');
            $data['session'] = new stdClass();
            $data['session']->year = 'N/A';
            $data['session']->month = '';
            $data['name'] = $name;
            $data['enrolled'] = 0;
            return view('student.studentdashboard')->with('data',$data);

        }
    }

    public function getfirstrow_ajax()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
            $data['session'] = true;
            $data['session_name'] = $active_session;
            $data['total_student'] = DB::table('sessiondatas')
                                    ->where('session_id',$active_session->id)
                                    ->distinct()
                                    ->get(['student_id'])
                                    ->count();
            
        }
        else
        {
            $data['session'] = false;
        }

        return $data;
    }

    public function getsecondrow_ajax()
    {
        $data['max_student_included'] = DB::table('max_students')
                            ->join('sections','sections.id','=','max_students.section_id')
                            ->select('sections.name','max_students.id','max_students.max_student')
                            ->get();
        // $data['didnt_included'] = DB::table('max_students')
        //                     ->join('sections','sections.id','!=','max_students.section_id')
        //                     ->select('sections.name')
        //                     ->get();
        $data['per_credit_value'] = DB::table('credit_values')
                                    ->join('semesters','semesters.id','credit_values.semester_id')
                                    ->select('credit_values.*','semesters.name')
                                    ->orderBy('semesters.name','asc')
                                    ->get();
        return $data;
    }

    public function getprereq_ajax($id)
    {
        $data['subjects'] = DB::table('subjects')->where('semester_id',$id)->get(['id']);

        if(count($data['subjects'])>0)
        {
            $subjects = $data['subjects'];
            $data['nodata'] = false;
            $main_sub = array();
            $id = array();
            $prereq = array();
            $type =array();
            for($i=0;$i<count($data['subjects']);$i++)
            {
                $get_prereq = DB::table('pre_reqs')->where('subject_id',$subjects[$i]->id)->first();
                if($get_prereq)
                {
                    $main_sub[$i] = DB::table('subjects')->where('id',$subjects[$i]->id)->pluck('name');
                    $id[$i] = $get_prereq->prerequisite_subject_id;
                    $type[$i] = 1; // UPDATE
                    $pre_req[$i] = DB::table('subjects')->where('id',$get_prereq->prerequisite_subject_id)->pluck('name');
                }
                else
                {
                    $main_sub[$i] = DB::table('subjects')->where('id',$subjects[$i]->id)->pluck('name');
                    $id[$i] = $subjects[$i]->id;
                    $type[$i] = 0;//INSERT
                    $pre_req[$i] ='-----';
                }
            }

            $data['main_sub'] = $main_sub;
            $data['id'] = $id;
            $data['prereq'] = $pre_req;
            $data['type'] = $type;
            
        }
        else
        {
            $data['nodata'] = true;
        }

        return $data;
    }

    public function show_update_max_ajax($id)
    {
        $data = DB::table('max_students')->join('sections','sections.id','=','max_students.section_id')->where('max_students.id',$id)->select('sections.name','max_students.id','max_students.max_student')->get();
        return $data;
    }

    public function set_update_max_ajax(Request $request)
    {
        $id = $request->id;
        $updated_value = $request->updated_value;
        $data = DB::table('max_students')
            ->where('id',$id)
            ->update(['max_student' => $updated_value]);
        //$data['update'] = true;
        return $id;    
    }
    public function showpervalues_ajax($id)
    {
        $data = DB::table('credit_values')->join('semesters','semesters.id','credit_values.semester_id')->where('credit_values.id',$id)->select('semesters.name','credit_values.*')->get();
        return $data;
    }

    public function setupdatepercredit_ajax(Request $request)
    {
        $id = $request->id;
        $regular = $request->regular;
        $retake = $request->retake;
        $recourse = $request->recourse;
        DB::table('credit_values')->where('id',$id)
            ->update(['regular_values' => $regular,'retake_values' => $retake,'recourse_values' => $recourse]);
    }

    public function getprereqsub_ajax(Request $request)
    {
      $sub_id = $request->id;
      $type = $request->type;
      if($type == 0)
      {
          $data['main_sub'] = DB::table('subjects')->where('id',$sub_id)->first();
          $semester = DB::table('subjects')->join('semesters','semesters.id','subjects.semester_id')->where('subjects.id',$sub_id)->select('semesters.name')->first();
         $data['subjects'] = DB::table('subjects')
                            ->join('semesters','semesters.id','subjects.semester_id')
                            ->where('semesters.name','<',$semester->name)
                            ->select('subjects.name as subname','subjects.id','semesters.name as semname')
                            ->get();
         $data['semesters'] = DB::table('subjects')
                            ->join('semesters','semesters.id','subjects.semester_id')
                            ->where('semesters.name','<',$semester->name)
                            ->distinct()
                            ->select('semesters.name as semname')
                            ->get(); 
        $data['selected_semester'] = $semester;
      }
      else if($type == 1)
      {
        $subject_id= DB::table('pre_reqs')->where('prerequisite_subject_id',$request->id)->pluck('subject_id');
         $data['pre_req'] = DB::table('subjects')
                            ->where('id',$sub_id)
                            ->pluck('name');
         $data['main_sub']  = DB::table('subjects')
                            ->where('id',$subject_id)
                            ->first();   
         $semester = DB::table('subjects')->join('semesters','semesters.id','subjects.semester_id')->where('subjects.id',$subject_id)->select('semesters.name')->first();
         $data['subjects'] = DB::table('subjects')
                            ->join('semesters','semesters.id','subjects.semester_id')
                            ->where('semesters.name','<',$semester->name)
                            ->select('subjects.name as subname','subjects.id','semesters.name as semname')
                            ->get();
         $data['semesters'] = DB::table('subjects')
                            ->join('semesters','semesters.id','subjects.semester_id')
                            ->where('semesters.name','<',$semester->name)
                            ->distinct()
                            ->select('semesters.name as semname')
                            ->get();   
        $data['selected_semester'] = $semester;                 
      }
      
      return $data;
    }

    public function postupdateprereq_ajax(Request $request)
    {
        $main_sub = $request->main_sub;
        $prereq = $request->prereq;

        $check = DB::table('pre_reqs')->where('subject_id',$main_sub)->first();
            if($check)
            {
                DB::table('pre_reqs')
                    ->where('subject_id',$main_sub)
                    ->update(['prerequisite_subject_id' => $prereq]);
            }
            else
            {
                DB::table('pre_reqs')->INSERT(
                    [
                        'prerequisite_subject_id' => $prereq,
                        'subject_id'        => $main_sub,
                    ]
                    );
            }
        $data['update'] = true;
        return $data;
    }

    public function deleteprereq_ajax($id)
    {
        $check  =DB::table('pre_reqs')->where('subject_id',$id)->first();
        if($check)
        {
            DB::table('pre_reqs')->where('subject_id',$id)->delete();
        }
        
    }

    public function getstudentdashdata_ajax()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $user_id = Session::get('user_id');

        $cgpa  = DB::table('sessiondatas')
                ->where('type','!=',4)
                ->where('student_id',$user_id)
                ->where('session_id','!=',$active_session->id)
                ->avg('cgpa');
        $completed_semester = DB::table('sessiondatas')
                        ->join('semesters','semesters.id','sessiondatas.semester_id')
                        ->where('sessiondatas.student_id',$user_id)
                        ->where('sessiondatas.session_id','!=',$active_session->id)
                        ->orderBy('semesters.name','desc')
                        ->pluck('semesters.name')
                        ->first();
        // $previous_semester  = DB::table('semesters')
        //                 ->where('semesters.name','<',$completed_semester)
        //                 ->orderBy('semesters.name','asc')
        //                 ->pluck('semesters.name')
        //                 ->first();
        $data['cgpa'] = $cgpa;
        if($completed_semester)
        {
            $data['user_has_completed_semester'] = true;
            $data['semester'] = $completed_semester;
        }
        else {
            $data['user_has_completed_semester'] = false;
        }

        $data['retake'] = DB::table('sessiondatas')
            ->where('session_id','!=',$active_session->id)
            ->where('type','!=',4)
            ->where('cgpa','=',0)
            ->where('student_id',Session::get('user_id'))
            ->join('semesters','semesters.id','=','sessiondatas.semester_id')
            ->join('subjects','subjects.id','=','sessiondatas.subject_id')
            ->select('subjects.name as subname','sessiondatas.type','semesters.name as semname')
            ->limit(5)
            ->get();
        return $data;
    }

    public function getteacherdata_ajax()
    {
        $data['teaching'] = DB::table('teachers')
                            ->join('subjects','subjects.id','teachers.subject_id')
                            ->where('teacher_id',Session::get('user_id'))
                            ->select('subjects.name')
                            ->get();
        $data['advising'] = DB::table('sections')->where('advisor_id',Session::get('user_id'))->where('session_id','!=',null)->pluck('name');
        return $data;
    }

    public function block()
    {
        $data= DB::table('blocks')->get();

        return view('admin.adminblockitem')->with('data',$data);
    }
    public function block_toggle($id)
    {
        $data = DB::table('blocks')->where('id',$id)->first();
        if($data->active == 1)
        {
            DB::table('blocks')
                    ->where('id',$id)
                    ->update(['active'=>0]);
        }
        else
        {
            DB::table('blocks')
                ->where('id',$id)
                ->update(['active'=>1]);
        }
        return back();
    }
}
