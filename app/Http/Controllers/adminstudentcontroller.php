<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class adminstudentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('users')->where('student',1)->paginate(10);
        return view('admin.student')->with('data',$data);
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

    public function getstudentsearchresult_ajax($string)
    {
        $data['student'] = DB::table('users')
                ->orWhere('name','like','%'.$string.'%')
                ->where('student',1)
                ->where('teacher',0)
                ->where('admin',0)
                ->limit(4)
                ->get();
        $data['id'] =DB::table('users')
                ->orWhere('user_id','like','%'.$string.'%')
                ->where('student',1)
                ->where('teacher',0)
                ->where('admin',0)
                ->limit(4)
                ->get();
        return $data;
    }

    public function enable($id)
    {
        DB::table('users')
            ->where('user_id',$id)
            ->update([
                'active' => 1,
            ]);
        return back();
    }
    public function disable($id)
    {
        DB::table('users')
            ->where('user_id',$id)
            ->update([
                'active' => 0,
            ]);
        return back();
    }

}
