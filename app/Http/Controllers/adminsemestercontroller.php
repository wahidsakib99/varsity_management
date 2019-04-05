<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class adminsemestercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $error = false;
        return view('admin.adminsemester')->with('error',$error);
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

    public function getsemester_ajax()
    {
        $datas = DB::table('semesters')->orderby('name','asc')->get();
        return $datas;
    }
    public function enabledisable_ajax($id,$active)
    {
        if($active == 1)
        {
            DB::table('semesters')->where('id',$id)->update(['active' =>0]);
            DB::table('semesters')
                ->join('sections','sections.semester_id','semesters.id')
                ->where('semesters.id',$id)
                ->update(['sections.session_id' => null]);
            $data['update'] = true;
        }
        else
        {
            DB::table('semesters')->where('id',$id)->update(['active' =>1]);
            
            $data['update'] = true;
        }
        return $data;
    }
    public function showmodaldata_ajax($id)
    {
        $data = DB::table('semesters')->where('id',$id)->get();
        return $data;
    }

    public function deletesemester_ajax($id)
    {
        DB::table('semesters')->where('id',$id)->delete();
        $data['delete'] = true;
        return $data;
    }

    public function addsemester(Request $request)
    {
        $semester = $request->semester_name;
        $regular = $request->regular;
        $retake = $request->retake;
        $recourse = $request->recourse;
        $request->validate([
            'semester_name' => 'required|numeric|gt:0',
            'regular'       => 'required|numeric|gt:0',
            'retake'        => 'required|numeric|gt:0',
            'recourse'      => 'required|numeric|gt:0',
        ]);
        $check = DB::table('semesters')->where('name',$semester)->first();
        if($check)
        {
            return back()->with('error','Semester Exist');
        }
        else
        {
    
            DB::table('semesters')->insert(
                [
                    'name' => $semester,
                    'active' => 1,
                ]
                );
            $semester_id = DB::table('semesters')->where('name',$semester)->first();
            DB::table('credit_values')->insert([
                'semester_id' => $semester_id->id,
                'regular_values' => $regular,
                'retake_values'  => $retake,
                'recourse_values' => $recourse
            ]);
                return back();
        }
    }
}
