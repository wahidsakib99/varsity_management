<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class advisorcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.advisor');
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
    public function showstudentlistforadvisor_ajax($id)
    {
        $advisor_id = Session::get('user_id');
        $users = DB::table('user_sections')
                ->where('section_id',$id)
                ->get();
        $active_session =DB::table('sessions')->where('active',1)->first();
        $all_data = array();
        for($i=0;$i<count($users);$i++)
        {
            $all_data[$i] = DB::table('sessiondatas')
                                ->join('subjects','subjects.id','=','sessiondatas.subject_id')
                                ->join('users','users.user_id','=','sessiondatas.student_id')
                                ->join('sections','sections.id','sessiondatas.section_id')
                                ->where('sessiondatas.student_id',$users[$i]->user_id)
                                ->where('sessiondatas.session_id',$active_session->id)
                                ->where('sessiondatas.pending',0)
                                ->orderBy('sessiondatas.student_id','asc')
                                ->select('sessiondatas.id','sections.name as secname','subjects.name as subname','users.name as uname','users.user_id as student_id','sessiondatas.type')
                                ->get();
        }
        $section_name = DB::table('sections')->where('id',$id)->first();
        $data['section_name'] = $section_name->name;
        if(count($all_data)>0)
        {
            $data['hasdata'] = true;
            $data['data'] = $all_data;
        }
        else
        {
            $data['hasdata'] = false;
        }
       
        return $data;

    }

    public function getsectionlist_ajax()
    {
        $section_list =  DB::table('sections')
                ->where('advisor_id',Session::get('user_id'))
                ->where('session_id','!=',null)
                ->orderBy('name','asc')
                ->get();
        
        if(count($section_list)>0)
        {
            $data['data'] = $section_list;
            $data['hassection'] = true;
        }
        else
        {
            $data['hassection'] = false;
        }
        return $data;
    }

    public function showapprovedadvisor_ajax($id)
    {
        $advisor_id = Session::get('user_id');
        $users = DB::table('user_sections')
                ->where('section_id',$id)
                ->get();
        $active_session =DB::table('sessions')->where('active',1)->first();
        $all_data = array();

        for($i=0;$i<count($users);$i++)
        {
            $all_data[$i] = DB::table('sessiondatas')
                                ->join('subjects','subjects.id','=','sessiondatas.subject_id')
                                ->join('users','users.user_id','=','sessiondatas.student_id')
                                ->join('sections','sections.id','sessiondatas.section_id')
                                ->where('sessiondatas.student_id',$users[$i]->user_id)
                                ->where('sessiondatas.session_id',$active_session->id)
                                ->where('sessiondatas.pending',1)
                                ->orderBy('sessiondatas.student_id','asc')
                                ->select('sessiondatas.id','sections.name as secname','subjects.name as subname','users.name as uname','users.user_id as student_id','sessiondatas.type')
                                ->get();
        }

        if(count($all_data)>0)
        {
            $data['hasdata'] = true;
            $data['data'] = $all_data;
        }
        else
        {
            $data['hasdata'] = false;
        }
       
        return $data;
    }

    public function acceptpending_ajax($id)
    {
        $section= DB::table('sessiondatas')->where('id',$id)->first();

        if($section)
        {
                $advisor_id = DB::table('sections')->where('id',$section->section_id)->first();
                if($advisor_id->advisor_id == Session::get('user_id'))
                {
                    DB::table('sessiondatas')
                        ->where('id',$id)
                        ->update(['pending' => 1]);
                    $data['update'] = true;
                }
                else
                {
                    $data['update'] = false;
                }
        }
        else
            {
                $data['update'] = false;
            }
        return $data;
    }

    public function deletepending_ajax($id)
    {
        $section= DB::table('sessiondatas')->where('id',$id)->first();

        if($section)
        {
                $advisor_id = DB::table('sections')->where('id',$section->section_id)->first();

                if($advisor_id->advisor_id == Session::get('user_id'))
                {
                    DB::table('sessiondatas')
                        ->where('id',$id)
                        ->delete();
                    $data['delete'] = true;
                }
                else
                {
                    $data['delete'] = false;
                }
        }
        else
        {
            $data['delete'] = false;
        }
        return $data;
    }

    public function makepending_ajax($id)
    {
        $section= DB::table('sessiondatas')->where('id',$id)->first();

        if($section)
        {
                $advisor_id = DB::table('sections')->where('id',$section->section_id)->first();

                if($advisor_id->advisor_id == Session::get('user_id'))
                {
                    DB::table('sessiondatas')
                        ->where('id',$id)
                        ->update(['pending' => 0]);
                    $data['pending'] = true;
                }
                else
                {
                    $data['pending'] = false;
                }
        }
        else
        {
            $data['pending'] = false;
        }

        return $data;
    }
}
