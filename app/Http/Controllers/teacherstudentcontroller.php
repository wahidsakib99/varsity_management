<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class teacherstudentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.teacherstudent');
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
    public function getsubjects_ajax()
    {
     if(Session::has('user_id'))
     {
         $data['error'] = false;
         $user_id = Session::get('user_id');
         $subjects = DB::table('teachers')
                ->join('subjects','subjects.id','teachers.subject_id')
                ->join('sections','sections.id','teachers.section_id')
                ->where('teachers.teacher_id',$user_id)
                ->where('teachers.session_id','!=',Null)
                ->select('subjects.name as subname','teachers.subject_id as sub_id','teachers.section_id as sec_id','sections.name as secname')
                ->get();
            if(count($subjects)>0)
            {
                $data['nodata'] = false;
                $data['data'] = $subjects;
            }
            else
            {
                $data['nodata'] = true;
            }
         
     }
     else
     {
         $data['error'] = true;
     }

     return $data;
    }

    public function getstudentsregular_ajax(Request $request)
    {
        $section_id = $request->section;
        $subject_id = $request->subject;
        $get_advisor = array();

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
                    ->where('sessiondatas.type',0)
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name')
                    ->get();
            for($i=0;$i<count($students);$i++)
            {
                $get_advisor[$i] = DB::table('user_sections')
                        ->join('sections','sections.id','user_sections.section_id')
                        ->join('users','users.user_id','sections.advisor_id')
                        ->where('user_sections.user_id',$students[$i]->student_id)
                        ->pluck('users.name');
            }

            if(count($students)>0)
            {
                $data['student'] = $students;
                $data['nodata'] = false;
                $data['advisor'] = $get_advisor;
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

    public function getstudentsretake_ajax(Request $request)
    {
        $section_id = $request->section;
        $subject_id = $request->subject;
        $get_advisor = array();

        $check_teacher = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->first();

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
                    ->where('sessiondatas.type',1)
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name')
                    ->get();
            for($i=0;$i<count($students);$i++)
            {
                $get_advisor[$i] = DB::table('user_sections')
                        ->join('sections','sections.id','user_sections.section_id')
                        ->join('users','users.user_id','sections.advisor_id')
                        ->where('user_sections.user_id',$students[$i]->student_id)
                        ->pluck('users.name');
            }

            if(count($students)>0)
            {
                $data['student'] = $students;
                $data['nodata'] = false;
                $data['advisor'] = $get_advisor;
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

    public function getstudentsrecourse_ajax(Request $request)
    {
        $section_id = $request->section;
        $subject_id = $request->subject;
        $get_advisor = array();

        $check_teacher = DB::table('teachers')->where('teacher_id',Session::get('user_id'))->first();

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
                    ->where('sessiondatas.type',2)
                    ->orderBy('sessiondatas.student_id','asc')
                    ->select('sessiondatas.student_id','sessiondatas.id','users.name')
                    ->get();
            for($i=0;$i<count($students);$i++)
            {
                $get_advisor[$i] = DB::table('user_sections')
                        ->join('sections','sections.id','user_sections.section_id')
                        ->join('users','users.user_id','sections.advisor_id')
                        ->where('user_sections.user_id',$students[$i]->student_id)
                        ->pluck('users.name');
            }

            if(count($students)>0)
            {
                $data['student'] = $students;
                $data['nodata'] = false;
                $data['advisor'] = $get_advisor;
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

    public function deletesubject_ajax(Request $request)
    {
        $session_id = $request->session_id;
        $type       = $request->type;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $active_session = DB::table('sessions')->where('active',1)->first();
        $session_check = DB::table('sessiondatas')->where('id',$session_id)->first();
        if($session_check->section_id == $section_id && $session_check->subject_id == $subject_id)
        {
            $data['user'] = true;
            DB::table('sessiondatas')->where('id',$session_id)->where('session_id',$active_session->id)->delete();
            $data['delete'] = true;
        }
        else
        {
            $data['user'] = false;
        }
        return $data;
    }

    public function get_max_mark_ajax($subject_id,$section_id)
    {
        return $subject_id;
    }
}
