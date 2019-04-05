<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class studentresultcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.studentresult');
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

    public function studentinfo_ajax()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $temp_array_to_hold_values ;
        $count_helper=0;

                $total_cgpa = 0;

                $name = DB::table('users')->where('user_id',Session::get('user_id'))->pluck('name')->first();
                $img = DB::table('users')->where('user_id',Session::get('user_id'))->pluck('image')->first();
                $completed_semester = DB::table('sessiondatas')->where('student_id',Session::get('user_id'))->where('session_id','!=',$active_session->id)->distinct()->pluck('semester_id');
                if(count($completed_semester)>0)
                {
                    for($j=0;$j<count($completed_semester);$j++)
                    {
                        $cgpa  = DB::table('sessiondatas')
                                ->where('type','!=',4)
                                ->where('student_id',Session::get('user_id'))
                                ->where('session_id','!=',$active_session->id)
                                ->where('semester_id',$completed_semester[$j])
                                ->avg('cgpa');
                        $total_cgpa = $total_cgpa+$cgpa;  
                    }
                    /* 
                        HERE $avarage_cgpa_ofIndividual_student this value is copied from adminresultcontroller.blade.php
                        So didnt change the variable name. Though it is not connected. 
                    */
                    $avarage_cgpa_ofIndividual_student['name'] = $name;
                    $avarage_cgpa_ofIndividual_student['img'] = $img;
                    $avarage_cgpa_ofIndividual_student['student_id'] = Session::get('user_id');
                    $avarage_cgpa_ofIndividual_student['averagecgpa'] = floor(($total_cgpa/count($completed_semester))*100)/100;
                    $temp_array_to_hold_values = $avarage_cgpa_ofIndividual_student;
                }
                else
                {   
                    $avarage_cgpa_ofIndividual_student['name'] = $name;
                    $avarage_cgpa_ofIndividual_student['img'] = $img;
                    $avarage_cgpa_ofIndividual_student['student_id'] = Session::get('user_id');
                    $avarage_cgpa_ofIndividual_student['averagecgpa'] = 0;
                    $temp_array_to_hold_values = $avarage_cgpa_ofIndividual_student;
                }
            $data['data'] = $temp_array_to_hold_values;

            $data['section'] = DB::table('user_sections')
                                ->join('sections','section_id','=','sections.id')    
                                ->where('user_sections.user_id',Session::get('user_id'))
                                ->select('sections.name')
                                ->first();

        return $data;
    }
    public function getresult_ajax($semester)
    {
        $id = Session::get('user_id');
        $active_session = DB::table('sessions')->where('active',1)->first();
        $semester_id = DB::table('semesters')->where('name',$semester)->first();

        if($semester_id)
        {
            $data['semester'] = true;
            $data['nodata'] = false;
            $datas = DB::table('sessiondatas')
                    ->where('student_id',$id)
                    ->where('sessiondatas.session_id','!=',$active_session->id)
                    ->where('type','!=',4)
                    ->where('sessiondatas.semester_id',$semester_id->id)
                    ->join('subjects','subjects.id','=','sessiondatas.subject_id')
                    ->join('out_of',function($join)
                    {
                        $join->on('out_of.subject_id','sessiondatas.subject_id')
                             ->on('out_of.session_id','sessiondatas.session_id')
                             ->on('out_of.section_id','sessiondatas.section_id');
                    })
                    ->select('sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid','sessiondatas.final','sessiondatas.grade','sessiondatas.cgpa','subjects.name','out_of.attendance as out_at','out_of.rora as out_rora','out_of.ct as out_ct','out_of.mid as out_mid','out_of.final as out_final')
                    //->select('sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid','sessiondatas.final','sessiondatas.grade','sessiondatas.cgpa','subjects.name')
                    ->get();
            if(count($datas)>0)
            {
                 $avg_cgpa = DB::table('sessiondatas')
                    ->where('student_id',$id)
                    ->where('session_id','!=',$active_session->id)
                    ->where('type','!=',4)
                    ->where('sessiondatas.semester_id',$semester_id->id)
                    ->avg('cgpa');
                $data['data'] = $datas;
                $data['avg'] = floor($avg_cgpa*100)/100;
            }
            else
            {
                $data['nodata'] = true;
            }
        }
        else
        {
            $data['semester'] = false;
        }
        return $data;
    }
    public function studentretake_ajax()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $datas = DB::table('sessiondatas')
            ->where('session_id','!=',$active_session->id)
            ->where('type','!=',4)
            ->where('cgpa','=',0)
            ->where('student_id',Session::get('user_id'))
            ->join('semesters','semesters.id','=','sessiondatas.semester_id')
            ->join('subjects','subjects.id','=','sessiondatas.subject_id')
            ->select('sessiondatas.attendance','sessiondatas.rora','sessiondatas.ct','sessiondatas.mid','sessiondatas.final','sessiondatas.grade','sessiondatas.cgpa','subjects.name as subname','sessiondatas.type','semesters.name as semname')
            ->get();
        if(count($datas)>0)
        {
            $data['nodata'] = false;
            $data['data'] = $datas;
        }
        else
        {
            $data['nodata'] = true;
        }
        return $data;
    }

    public function showincomplete_ajax()
    {
        $incom = array();
        $sem = array();
        $count_helper = 0;
        $active_session = DB::table('sessions')->where('active',1)->first();
        $semester = DB::table('sessiondatas')
                    ->where('student_id',Session::get('user_id'))
                    ->where('session_id','!=',$active_session->id)
                    ->distinct()
                    ->pluck('semester_id');
       if(count($semester)>0)
        {
            $data['enroll'] = true;
            for($i=0;$i<count($semester);$i++)
            {
                $subjects[$i] = DB::table('subjects')
                        ->where('semester_id',$semester[$i])
                        ->get();
            }
            for($i=0;$i<count($subjects);$i++)
            {
                $temp_sub = $subjects[$i];
                for($j=0;$j<count($temp_sub);$j++)
                {
                $exist = DB::table('sessiondatas')
                        ->where('student_id',Session::get('user_id'))
                        ->where('subject_id',$temp_sub[$j]->id)
                        ->first();
                    if($exist)
                    {
                        //SUBJECT IS TAKEN
                    }
                    else
                    {
                        $incom[$count_helper] = $temp_sub[$j]->name;
                        $sem[$count_helper] = DB::table('semesters')->where('id',$temp_sub[$j]->semester_id)->pluck('name');
                        $count_helper++;
                    }
                }
            }

            if(count($incom)>0)
            {
                $data['nodata'] = false;
                $data['subject'] = $incom;
                $data['sem'] = $sem;
            }
            else
            {
                $data['nodata'] = true;
            }
        }
        else
        {
            $data['enroll'] = false;
        }

        return $data;
    }
}
