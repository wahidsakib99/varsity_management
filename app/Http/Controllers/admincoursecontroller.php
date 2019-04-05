<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class admincoursecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admincourse');
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

    public function showsemesters_ajax(Request $request)
    {
        $semesters = DB::table('semesters')
        ->where('active',1)
        ->orderBy('name','asc')
        ->get();
        if(count($semesters)>0)
        {
            $data['nodata'] = false;
            $data['data'] = $semesters;
        }
        else
        {
            $data['nodata'] = true;
        }
        return $data;
    }

    public function showsubjects_ajax($id)
    {
        $subjects = DB::table('subjects')
            ->where('semester_id',$id)
            ->get();
        $semester_name = DB::table('semesters')
            ->where('id',$id)
            ->first();
        if(count($subjects)>0)
        {
            $data['nodata'] = false;
            $data['data'] = $subjects;
            
        }
        else
        {
            $data['nodata'] = true;
        }
        $data['semester_name'] = $semester_name->name;
        return $data;
    }

    public function updatesubject_ajax($id)
    {
        $data = DB::table('subjects')
            ->where('id',$id)
            ->get();
            return $data;
    }

    public function saveupdatesubject_ajax($id,Request $request)
    {
        $subject_name = $request->input('subject_name');
        $subject_code = $request->input('subject_code');
        $subject_credit = $request->input('subject_credit');
        DB::table('subjects')
            ->where('id',$id)
            ->update(['name' => $subject_name, 'code' => $subject_code, 'credit' => $subject_credit]);
        $data['update'] = true;
        $data['semester'] = DB::table('subjects')->where('id',$id)->pluck('semester_id');
        return $data;
    }

    public function showdeletesubject_ajax($id)
    {
        $data = DB::table('subjects')
            ->where('id',$id)
            ->pluck('name');
            return $data;
    }
    public function deletesubject_ajax($id)
    {
        $semester = DB::table('subjects')->where('id',$id)->pluck('semester_id');
        DB::table('subjects')
            ->where('id',$id)
            ->update(['active' => 0]);
        $data['delete'] =true;
        $data['semester'] = $semester;
        return $data;
    }

    public function savesubject_ajax(Request $request)
    {
        $name = $request->input('name');
        $code = $request->input('code');
        $credit = $request->input('credit');
        $semester = $request->input('semester');
       $exist =DB::table('subjects')
            ->where('name',$name)
            ->where('code',$code)
            ->where('credit',$credit)
            ->where('semester_id',$semester)
            ->first();
            if($exist)
            {
                $data['insert'] = false;
            }
            else {
                DB::table('subjects')->insert(
                    [
                        'name' =>$name,
                        'code' => $code,
                        'credit' => $credit,
                        'semester_id' => $semester,
                        'active' => 1,
                    ]
                    );
                    $data['insert'] = true;
            }
        return $data;
    }
    public function activesubject_ajax($id)
    {
        $semester = DB::table('subjects')->where('id',$id)->pluck('semester_id');  
        DB::table('subjects')
            ->where('id',$id)
            ->update(['active' => 1]);
        $data['semester'] = $semester;
        return $data;
    }

    public function addmultiple()
    {
        return view('admin.adminmultiple');
    }
    public function savemultiple_ajax(Request $request)
    {
        $course_name  = $request->course_name;
        $course_code = $request->course_code;
        $course_credit = $request->course_credit;
        $semester = $request->semester;
        $data['insert'] = true;
        for($i =0;$i<count($course_name);$i++)
        {
           $exist =  DB::table('subjects')
                        ->where('name',$course_name[$i])
                        ->where('semester_id',$semester)
                        ->first();
            if($exist)
            {
                $data['insert'] = false;
            }
        }
        if($data['insert'] == true)
        {
            for($i =0;$i<count($course_name);$i++)
            {
              DB::table('subjects')->insert(
                  [
                    'name'=>$course_name[$i],
                    'code' => $course_code[$i],
                    'credit' => $course_credit[$i],
                    'semester_id' => $semester,
                    'active' => 1,
                  ]
                  );
            }
        }
        return $data;
    }
}
