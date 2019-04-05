<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class adminsessioncontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.adminsession');
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

    public function overview_ajax()
    {
        $sessions = DB::table('sessions')
            ->orderBy('id','dsc')
            ->get();
        $total_student = array();
        for($i=0;$i<count($sessions);$i++) //COUNTING TOTAL STUDENT FOR EACH SESSION
        {
            $total_student[$i] = DB::table('sessiondatas')
                                    ->where('session_id',$sessions[$i]->id)
                                    ->distinct()
                                    ->pluck('student_id')
                                    ->count();
        }
        if(count($sessions)>0)
        {
            $data['sessionhasdata'] = true;
            $data['sessions'] = $sessions;
            $data['totalstudent'] = $total_student;
        }
        else
            $data['sessionhasdata'] = false;

        return $data;
    }

    public function blockunblock_ajax($id,$todo, Request $request)
    {
        if($todo == 0)
        {
            DB::table('sessions')
                ->where('id',$id)
                ->update(['active' =>0]);
            $data['blockunblock']= true;
        }
        elseif($todo == 1)
        {
            DB::table('sessions')
                ->where('active',1)
                ->update(['active' => 0]);
            DB::table('sessions')
                ->where('id',$id)
                ->update(['active' =>1]);
            $data['blockunblock']= true;
        }
        return $data;
    }

    public function deletemodal_ajax($id)
    {
        $datas = DB::table('sessions')
            ->where('id',$id)
            ->get();
        $data['session'] = $datas;
        return $data;
    }

    public function deletesession_ajax($id)
    {
        
        DB::table('sessions')
            ->where('id',$id)
            ->delete();
        $data['delete'] = true;
        return $data;
    }

    public function showsemestersandteachers_ajax()
    {
        $semesters = DB::table('semesters')
            ->where('active',1)
            ->orderBy('name','asc')
            ->get();
        $teachers = DB::table('users')
            ->where('active',1)
            ->where('teacher',1)
            ->get();
        if(count($semesters)>0)
        {
            $data['semesterhasdata'] =true;
            $data['semesters'] = $semesters;
        }
        else
        {
            $data['semesterhasdata'] =false;
        }
        if(count($teachers)>0)
        {
            $data['teacherhasdata'] =true;
            $data['teachers'] = $teachers;
        }
        else
        {
            $data['teacherhasdata'] =false;
        }

        return $data;
    }

    public function save_section_ajax(Request $request)
    {
        $semester = $request->input('semester');
        $section_name = $request->input('section_name');
        $advisor    = $request->input('advisor');
        $max_stu = $request->max_stu;
        $active_session =DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
            $data['nosession'] = false;
            $exist =DB::table('sections')
                ->where('semester_id',$semester)
                ->where('name',$section_name)
                ->first();
        if($exist)
        {
            $exist_all =DB::table('sections')
                    ->where('semester_id',$semester)
                    ->where('name',$section_name)
                    ->where('advisor_id',$advisor)
                    ->where('session_id',$active_session->id)
                    ->first();
            if($exist_all)
            {
                $data['insert'] = false;
            }
            else
            {
                DB::table('sections')
                    ->where('id',$exist->id)
                    ->update(['advisor_id' => $advisor,'session_id' => $active_session->id]);
                DB::table('max_students')->where('section_id',$exist->id)
                    ->update([
                        'max_student' => $max_stu,
                    ]);
                $data['insert'] = true;
            }
        }
        else
        {
            DB::table('sections')->insert(
                [
                    'name' => $section_name,
                    'session_id' => $active_session->id,
                    'advisor_id' => $advisor,
                    'semester_id' => $semester
                ]
                );
            $section_id = DB::table('sections')
                    ->where('name',$section_name)
                    ->where('session_id',$active_session->id)
                    ->where('advisor_id',$advisor)
                    ->where('semester_id',$semester)
                    ->first();
            DB::table('max_students')->insert([
                'section_id' => $section_id->id,
                'max_student' => $max_stu,
            ]);
                $data['insert'] = true;
        }
    }
    else
    {
        $data['nosession'] = true;
    }
    return $data;
}


    public function viewsessionsection_ajax()
        {
            $sections = DB::table('sections')->orderBy('name','asc')->distinct()->get();
            $teacher = DB::table('users')->where('active',1)->where('teacher',1)->get();

            if(count($sections)>0)
            {
                $data['sectionhasdata'] = true;
                $data['sections'] = $sections;
                $data['teachers'] = $teacher;
            }
            else
            {
                $data['sectionhasdata'] = false;
            }
            return $data;
        }

        public function saveselectedsection_ajax(Request $request)
        {
            $section_id = $request->input('section');
            $advisor_id = $request->input('advisor');
            $month = $request->input('month');
            $year = $request->input('year');

            $exist = DB::table('sessions')
                    ->where('month',$month)
                    ->where('year',$year)
                    ->first();
            if($exist)
            {
                $data['insert'] = false;
            }
            else
            {
                DB::table('sessions')
                    ->where('active',1)
                    ->update(['active' =>0]);
                DB::table('sessions')->insert(
                    [
                        'year' => $year,
                        'month'=>$month,
                        'active'=>1,
                    ]
                    );
                $data['insert'] = true;
                DB::table('sections')
                    ->update(['session_id' => null]);
                DB::table('user_sections')
                    ->update(['section_id' => null]);
                DB::table('teachers')
                    ->update(['session_id' => null]);
            $active_session = DB::table('sessions')->where('active',1)->first();
            if($section_id)
            {
                for($i=0;$i<count($section_id);$i++)
                {
                    DB::table('sections')
                        ->where('id',$section_id[$i])
                        ->update(['session_id' => $active_session->id,'advisor_id' => $advisor_id[$i]]);
                }
            }
        }
        return $data;
    }

    public function assignteacher_ajax(Request $request)
    {
        if($request->ajax())
        {
            $active_session = DB::table('sessions')
                ->where('active',1)
                ->first();
            if($active_session)
            {
                $available_section = DB::table('sections')->where('session_id',$active_session->id)->orderBy('name','asc')->get();
                $data['sections'] = $available_section; 
                $subjects = DB::table('subjects')
                    ->where('subjects.active',1)
                    ->join('semesters','semesters.id','=','subjects.semester_id')
                    ->join('sections','sections.semester_id','=','semesters.id')
                    ->where('sections.session_id',$active_session->id)
                    ->leftjoin('teachers',function($join)
                    {
                        $join->on('teachers.section_id','sections.id')
                             ->on('teachers.subject_id','subjects.id');
                    })
                    ->where('teachers.session_id',null)
                    ->select('subjects.id as subid','subjects.name as subname','sections.name as secname','sections.id as secid')
                    ->orderBy('sections.name','asc')
                    ->get();
                $teacher = DB::table('users')
                    ->where('active',1)
                    ->where('teacher',1)
                    ->get();
                $data['session'] = true;
                $data['subjects'] = $subjects;
                $data['teachers'] = $teacher;
                return $data;
            }
            else {
                $data['session'] = false;
                return $data;
            }
        }
    }

    public function saveassignedteacher_ajax(Request $request)
    {
        $sections = $request->input('section');
        $subject  = $request->input('subjects');
        $teacher  = $request->input('teacher');
        $failed = array();
        $c = 0;//FOR COUNT
        if($subject)
        {
            
            $data['noinput'] = false;
            $active_session = DB::table('sessions')->where('active',1)->first();
            for($i=0;$i<count($subject);$i++)
            {
                $exist = DB::table('teachers')
                        ->where('section_id',$sections[$i])
                        ->where('subject_id',$subject[$i])
                        ->first();
                if($exist)
                {
                    $exist_all = DB::table('teachers')
                            ->where('section_id',$sections[$i])
                            ->where('subject_id',$subject[$i])
                            ->where('session_id',$active_session->id)
                            ->where('teacher_id',$teacher[$i])
                            ->first();
                    $exist_out_of =  DB::table('out_of')
                            ->where('section_id',$sections[$i])
                            ->where('subject_id',$subject[$i])
                            ->where('session_id',$active_session->id)
                            ->first();
                    if($exist_all)
                    { //EVERYTHING EXIST,,QUIT 
                        $failed[$c] = $subject[$i].'->'.$sections[$i].'->'.$teacher[$i];
                        $c++;
                        
                    }
                    else
                    {
                        //Subject exist need to update
                        DB::table('teachers')
                            ->where('id',$exist->id)
                            ->update(['teacher_id' => $teacher[$i], 'session_id' => $active_session->id]);
                        if(!$exist_out_of)
                        {
                            DB::table('out_of')->insert(
                                [
                                    'section_id' => $sections[$i],
                                    'subject_id' => $subject[$i],
                                    'session_id' => $active_session->id,
                                    'attendance' => 10,
                                    'rora'       => 10,
                                    'ct'         => 10,
                                    'mid'        => 20,
                                    'final'      => 50,
                                ]
                                );
                        }
                            $data['insert'] = true;
                    }
                    
                }
                else
                {
                    //Subject does not exist need to insert
                    DB::table('teachers')->insert(
                        [
                            'section_id' => $sections[$i],
                            'subject_id' => $subject[$i],
                            'teacher_id' => $teacher[$i],
                            'session_id' => $active_session->id,
                        ]
                        );
                    DB::table('out_of')->insert(
                        [
                            'section_id' => $sections[$i],
                            'subject_id' => $subject[$i],
                            'session_id' => $active_session->id,
                            'attendance' => 10,
                            'rora'       => 10,
                            'ct'         => 10,
                            'mid'        => 20,
                            'final'      => 50,
                        ]
                        );
                        $data['insert'] = true;
                }
            }
        }
        else
        {
            $data['noinput'] = true;
        }
        $data['failed'] = $failed;
        return $data;
    }

    public function showassignedteacher_ajax()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
            
            $data['nosession'] = false;
            $datas = DB::table('teachers') 
                    ->join('subjects','subjects.id','=','teachers.subject_id')
                    ->join('users','users.user_id','=','teachers.teacher_id')
                    ->join('sections','sections.id','=','teachers.section_id')
                    ->select('teachers.id','subjects.name as subname','sections.name as secname','users.name as teachername')
                    ->where('teachers.session_id',$active_session->id)
                    ->orderBy('secname','asc')
                    ->get();
            $teachers = DB::table('users')
                    ->where('active',1)
                    ->where('teacher',1)
                    ->get();
            if(count($datas)>0)
            {
                $data['failed'] = false;
                $data['data'] = $datas;
                $data['teachers'] = $teachers;
            }
            else
            {
                $data['failed'] =true;
            }
        }
        else
        {
            $data['nosession'] =true;
        }

        return $data;
    }

    public function deleteassignedteacher_ajax($id)
    {
        $delete = DB::table('teachers')
            ->where('id',$id)
            ->update(['session_id' =>null]);
         $data['delete'] = true;
         return $data;

    }

    public function updateselectedteacher_ajax(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $teacher_id =$request->input('teacher');

            for ($i=0; $i < count($id); $i++) { 
                DB::table('teachers')
                    ->where('id',$id[$i])
                    ->update(['teacher_id' => $teacher_id[$i]]);
            }
            $data['update'] = true;
           
        }
        else 
            $data['update'] = false;
            return $data;
    }
    
    public function updatedadvisor_ajax()
    {
 $active_session = DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
            $data['nosession'] = false;
            $datas = DB::table('sections')
                ->join('semesters','semesters.id','=','sections.semester_id')
                ->join('users','users.user_id','=','sections.advisor_id')
                ->where('sections.session_id',$active_session->id)
                ->select('sections.id','sections.name as secname','users.name as advisorname','users.user_id')
                ->get();
            $unmarked_data = DB::table('sections')
                ->join('semesters','semesters.id','=','sections.semester_id')
                ->where('sections.session_id',null)
                ->select('sections.id','sections.name as secname')
                ->get();
            $teachers = DB::table('users')
                ->where('active',1)
                ->where('teacher',1)
                ->get();
        
            if (count($datas)>0 || count($unmarked_data)>0) 
            {
                $data['nodata'] = false;
                $data['data'] = $datas;
                $data['teachers'] = $teachers;
                $data['unmarked'] = $unmarked_data;
            }
            else
                $data['nodata'] = true;
           
            
        }
        else {
            $data['nosession'] = true;
        }

        return $data;

    }

    public function deleteassignedadvisor_ajax($id)
    {
        $delete = DB::table('sections')
        ->where('id',$id)
        ->update(['session_id' => null]);
     $data['delete'] = true;
     return $data;
    }

    public function enablesectiondadvisor_ajax($id, Request $request)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $teacher = $request->input('teacher');
        DB::table('sections')
            ->where('id',$id)
            ->update(['advisor_id' => $teacher,'session_id' => $active_session->id]);
        $data['insert'] = true;
        return $data;
    }

    public function updateselectedadvisor_ajax(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $advisor_id =$request->input('advisor');

            for ($i=0; $i < count($id); $i++) { 
                DB::table('sections')
                    ->where('id',$id[$i])
                    ->update(['advisor_id' => $advisor_id[$i]]);
            }
            $data['update'] = true;
           
        }
        else 
            $data['update'] = false;
            return $data;
    } 

public function searchsection_ajax($text)
{
    // $section = DB::table('semesters')
    //             ->join('sections','sections.semester_id','semesters.id')
    //             ->where('sections.name','like','%'.$text.'%')
    //             ->where('sections.session_id','!=',null)
    //             ->where('subjects.active',1)
    //             ->join('subjects','subjects.semester_id','sections.semester_id')
    //             ->orWhere('subjects.name','like','%'.$text.'%')
    //             ->leftjoin('teachers',function($join)
    //             {
    //                 $join->on('teachers.section_id','sections.id')
    //                      ->on('teachers.subject_id','subjects.id');
    //             })
    //             ->where('teachers.session_id',null)
    //             ->where('subjects.active',1)
    //             ->limit(8)
    //             ->select('subjects.id as subid','subjects.name as subname','sections.name as secname','sections.id as secid')
    //             ->get();
    $active_session = DB::table('sessions')->where('active',1)->first();
    $section = DB::table('subjects')
                ->where('subjects.active',1)
                ->join('semesters','semesters.id','=','subjects.semester_id')
                ->join('sections','sections.semester_id','=','semesters.id')
                ->where('sections.session_id',$active_session->id)
                ->leftjoin('teachers',function($join)
                {
                    $join->on('teachers.section_id','sections.id')
                        ->on('teachers.subject_id','subjects.id');
                })
                ->where('teachers.session_id',null)
                ->where('sections.name','like','%'.$text.'%')
                ->orWhere('subjects.name','like','%'.$text.'%')
                ->where('teachers.session_id',null)
                ->where('subjects.active',1)
                ->select('subjects.id as subid','subjects.name as subname','sections.name as secname','sections.id as secid')
                ->orderBy('sections.name','asc')
                ->get();
    $teacher = DB::table('users')
                ->where('active',1)
                ->where('teacher',1)
                ->get();
    $data['subjects'] = $section;
    $data['teachers'] = $teacher;
    return $data;
}

public function searchsectionandteacher_ajax($text)
{
    $active_session = DB::table('sessions')->where('active',1)->first();
    $data['data'] = DB::table('teachers')
                    ->where('teachers.session_id','!=',null)
                    ->join('sections','teachers.section_id','sections.id')
                    ->where('sections.name','like','%'.$text.'%')
                    ->join('subjects','subjects.id','teachers.subject_id')
                    ->orWhere('subjects.name','like','%'.$text.'%')
                    ->where('teachers.session_id','!=',null)
                    ->join('users','users.user_id','teachers.teacher_id')
                    ->orWhere('users.name','like','%'.$text.'%')
                    ->where('teachers.session_id','!=',null)
                    ->select('teachers.id','subjects.name as subname','sections.name as secname','users.name as teachername')
                    ->limit(8)
                    ->get();
    $data['teachers'] = DB::table('users')
                    ->where('active',1)
                    ->where('teacher',1)
                    ->get();

    return $data;
}

public function searchsectionadvisor_ajax($text)
{
    $data['data'] = DB::table('sections')
                    ->where('sections.name','like','%'.$text.'%')
                    ->join('users','users.user_id','sections.advisor_id')
                    ->orWhere('users.name','like','%'.$text.'%')
                    ->orWhere('users.user_id','like','%'.$text.'%')
                    ->limit(8)
                    ->select('sections.id','sections.name as secname','users.name as advisorname','users.user_id','sections.session_id')
                    ->get();
    $data['teachers']= DB::table('users')
                ->where('active',1)
                ->where('teacher',1)
                ->get();
    return $data;
}

public function get_selected_section_ajax($id,Request $request)
{
    if($request->ajax())
    {
        $active_session = DB::table('sessions')
            ->where('active',1)
            ->first();
        if($active_session)
        {
            $available_section = DB::table('sections')->where('session_id',$active_session->id)->orderBy('name','asc')->get();
            $data['sections'] = $available_section; 
            $subjects = DB::table('subjects')
                ->where('subjects.active',1)
                ->join('semesters','semesters.id','=','subjects.semester_id')
                ->join('sections','sections.semester_id','=','semesters.id')
                ->where('sections.id',$id)
                ->where('sections.session_id',$active_session->id)
                ->leftjoin('teachers',function($join)
                {
                    $join->on('teachers.section_id','sections.id')
                         ->on('teachers.subject_id','subjects.id');
                })
                ->where('teachers.session_id',null)
                ->select('subjects.id as subid','subjects.name as subname','sections.name as secname','sections.id as secid')
                ->orderBy('sections.name','asc')
                ->get();
            $teacher = DB::table('users')
                ->where('active',1)
                ->where('teacher',1)
                ->get();
            $data['session'] = true;
            $data['subjects'] = $subjects;
            $data['teachers'] = $teacher;
            return $data;
        }
        else {
            $data['session'] = false;
            return $data;
        }
    }  
}
}
