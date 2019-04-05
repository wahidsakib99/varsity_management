<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class teacheruploadresultcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.upload');
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

    public function getstudents_ajax(Request $request)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $section_id = $request->section;
        $subject_id = $request->subject;

        $check_teacher = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->where('section_id',$section_id)->where('subject_id',$subject_id)->first();
        
        if($check_teacher)
        {
            $section_name = DB::table('sections')->where('id',$section_id)->pluck('name')->first();
            $subject_name = DB::table('subjects')->where('id',$subject_id)->pluck('name')->first();
            $data['user'] = true;
            $active_session = DB::table('sessions')->where('active',1)->first();
            $students = DB::table('sessiondatas')
                    ->join('users','users.user_id','sessiondatas.student_id')
                    ->where('sessiondatas.section_id',$section_id)
                    ->where('sessiondatas.subject_id',$subject_id)
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->where('sessiondatas.cgpa',Null)
                    ->where('sessiondatas.pending',1)
                    ->where('sessiondatas.type',0) //REGULAR
                    ->orWhere('sessiondatas.type',2) // RECOURSE
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name','sessiondatas.type')
                    ->get();
            $out_of = DB::table('out_of')
                    ->where('session_id',$active_session->id)
                    ->where('subject_id',$subject_id)
                    ->where('section_id',$section_id)
                    ->first();
            $data['out_of'] = $out_of;

            if(count($students)>0)
            {
                $data['student'] = $students;
                $data['nodata'] = false;
            }
            else
            {
                $data['nodata'] = true;
            }
            $data['section'] = $section_name;
            $data['subject'] = $subject_name;

        }
        else
        {
            $data['user'] = false;
        }
        return $data;
    }

   public function postresultregular_ajax(Request $request)
   {
        $id  = $request->id;
        $attendance = $request->attendance;
        $rora = $request->rora;
        $ct = $request->ct;
        $mid = $request->mid;
        $final = $request->final;
        $grade = $request->grade;
        $cgpa = $request->cgpa;

        for($i=0;$i<count($id);$i++)
        {
            DB::table('sessiondatas')
                ->where('id',$id[$i])
                ->update([
                    'attendance' => $attendance[$i],
                    'rora'       => $rora[$i],
                    'ct'         => $ct[$i],
                    'mid'        => $mid[$i],
                    'final'      => $final[$i],
                    'grade'      => $grade[$i],
                    'cgpa'       => $cgpa[$i],
                ]);
        }
        $data['update'] = true;
   }

   public function getretakestudentresult_ajax(Request $request)
   {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $section_id = $request->section;
        $subject_id = $request->subject;

        $check_teacher = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->where('section_id',$section_id)->where('subject_id',$subject_id)->first();
        
        if($check_teacher)
        {
            $section_name = DB::table('sections')->where('id',$section_id)->pluck('name')->first();
            $subject_name = DB::table('subjects')->where('id',$subject_id)->pluck('name')->first();
            $data['user'] = true;
            $active_session = DB::table('sessions')->where('active',1)->first();
            $students = DB::table('sessiondatas')
                    ->join('users','users.user_id','sessiondatas.student_id')
                    ->where('sessiondatas.section_id',$section_id)
                    ->where('sessiondatas.subject_id',$subject_id)
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->where('sessiondatas.cgpa',Null)
                    ->where('sessiondatas.pending',1)
                    ->where('sessiondatas.type',1) //RETAKE
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name','sessiondatas.type','sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid')
                    ->get();

            if(count($students)>0)
            {
                $data['student'] = $students;
                $data['nodata'] = false;
            }
            else
            {
                $data['nodata'] = true;
            }
            $data['section'] = $section_name;
            $data['subject'] = $subject_name;

        }
        else
        {
            $data['user'] = false;
        }
        return $data;
   }

   public function postresultretake_ajax(Request $request)
   {
            $id  = $request->id;
            $attendance = $request->attendance;
            $final = $request->final;
            $grade = $request->grade;
            $cgpa = $request->cgpa;
    $check = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->where('subject_id',$request->subject)->where('section_id',$request->section)->first();
        if($check)  
            {   
                for($i=0;$i<count($id);$i++)
                    {
                        DB::table('sessiondatas')
                            ->where('id',$id[$i])
                            ->update([
                                'final'      => $final[$i],
                                'grade'      => $grade[$i],
                                'cgpa'       => $cgpa[$i],
                                ]);
                    }
                $data['update'] = true;
        }
    }

    public function getupdatestudent_ajax(Request $request)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $section_id = $request->section;
        $subject_id = $request->subject;

        $check_teacher = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->where('section_id',$section_id)->where('subject_id',$subject_id)->first();
        
        if($check_teacher)
        {
            $section_name = DB::table('sections')->where('id',$section_id)->pluck('name')->first();
            $subject_name = DB::table('subjects')->where('id',$subject_id)->pluck('name')->first();
            $data['user'] = true;
            $active_session = DB::table('sessions')->where('active',1)->first();
            $students_reg_rec = DB::table('sessiondatas')
                    ->join('users','users.user_id','sessiondatas.student_id')
                    ->where('sessiondatas.section_id',$section_id)
                    ->where('sessiondatas.subject_id',$subject_id)
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->where('sessiondatas.cgpa','!=',Null)
                    ->where('sessiondatas.pending',1)
                    ->where('sessiondatas.type',0) //REGULAR
                    ->orWhere('sessiondatas.type',2)//RECOURSE
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name','sessiondatas.type','sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid','sessiondatas.final','sessiondatas.grade','sessiondatas.cgpa')
                    ->get();
            $students_ret= DB::table('sessiondatas')
                    ->join('users','users.user_id','sessiondatas.student_id')
                    ->where('sessiondatas.section_id',$section_id)
                    ->where('sessiondatas.subject_id',$subject_id)
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->where('sessiondatas.cgpa','!=',Null)
                    ->where('sessiondatas.pending',1)
                    ->where('sessiondatas.type',1) //REGULAR
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name','sessiondatas.type','sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid','sessiondatas.final','sessiondatas.grade','sessiondatas.cgpa')
                    ->get();

            if(count($students_reg_rec)>0 || count($students_ret)>0)
            {
                $data['regrec'] = $students_reg_rec;
                $data['ret'] = $students_ret;
                $data['nodata'] = false;
            }
            else
            {
                $data['nodata'] = true;
            }
            $data['section'] = $section_name;
            $data['subject'] = $subject_name;

        }
        else
        {
            $data['user'] = false;
        }
        return $data;
    }

    public function restore_regrec_ajax($id)
    {
        DB::table('sessiondatas')
            ->where('id',$id)
            ->update([
                'attendance' => null,
                'rora'       => null,
                'ct'         => null,
                'mid'        => null,
                'final'      => null,
                'cgpa'       => null,
                'grade'      => null,
            ]);
        $data['update'] = true;
        return $data;
    }

    public function restore_ret_ajax($id)
    {
        DB::table('sessiondatas')
            ->where('id',$id)
            ->update([
                'final'      => null,
                'cgpa'       => null,
                'grade'      => null,
            ]);

        $data['update'] = true;
        return $data;
    }

    public function getout_of_data_ajax(Request $request)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $data['data'] = DB::table('out_of')
                    ->where('section_id',$request->section_id)
                    ->where('subject_id',$request->subject_id)
                    ->where('session_id',$active_session->id)
                    ->first();
        return $data;
    }

    public function save_out_of_ajax(Request $request)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $exist_id  =  DB::table('out_of')
                ->where('section_id',$request->section_id)
                ->where('subject_id',$request->subject_id)
                ->where('session_id',$active_session->id)
                ->first();
        if($exist_id)
        {
            DB::table('out_of')
                ->where('id',$exist_id->id)
                ->update([
                    'attendance' => $request->attendance,
                    'rora'       => $request->rora,
                    'ct'         => $request->ct,
                    'mid'        => $request->mid,
                    'final'      => $request->final,
                ]);
            $data['update'] = true;
        }
        return $data;
    }

    public function get_max_mark_ajax($subject_id,$section_id)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $data['out_of'] = DB::table('out_of')
                    ->where('section_id',$section_id)
                    ->where('subject_id',$subject_id)
                    ->where('session_id',$active_session->id)
                    ->first();
        return $data;
    }
}
