<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class profilecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function studentProfile()
    {
        $id = Session::get('user_id');
        $profile_data = DB::table('users')
                        ->join('profiles','profiles.user_id','=','users.user_id')
                        ->where('users.user_id',$id)
                        ->select('profiles.*','users.name','users.name','users.image','users.email')
                        ->get();
        if(count($profile_data)>0)
        {
            $data['data'] = $profile_data;
            $data['nodata'] = false;
            return view('student.studentprofile')->with('data',$data['data'])->with('error',$data['nodata']);
        }
        else
        {
            $data['nodata'] = true;
            return view('student.studentprofile')->with('error',$data['nodata']);
        }
        
        // return view('student.studentprofile')->with('data',$data['data']);
        // return $data['data'];
    }

    public function saveprofile($id,Request $request)
    {
        $name = $request->name;
        $bdate = $request->bdate;
        $phoneno= $request->mobile;
        $gender = $request->gender;
        $email = $request->email;

        $request->validate(
            [
                'bdate' => 'required | Date',
                'email' => 'required | email',
                'name'  => 'required',
                'mobile'=> 'required',
            ]
            );
        DB::table('profiles')
            ->where('id',$id)
            ->update(['phoneno'=>$phoneno,'gender' => $gender,'bdate'=>$bdate]);
        DB::table('users')
            ->where('user_id',Session::get('user_id'))
            ->update(['name'=>$name,'email' => $email]);

        return back();
    }

    public function editprofile()
    {
        $id = Session::get('user_id');
        $profile_data = DB::table('users')
                        ->join('profiles','profiles.user_id','=','users.user_id')
                        ->where('users.user_id',$id)
                        ->select('profiles.*','users.name','users.name','users.image','users.email')
                        ->get();
        if(count($profile_data)>0)
        {
            $data['data'] = $profile_data;
            $data['nodata'] = false;
            return view('student.editprofile')->with('data',$data['data'])->with('error',$data['nodata']);
        }
        else
        {
            $data['nodata'] = true;
            return view('student.editprofile')->with('error',$data['nodata']);
        }
        
        // return view('student.studentprofile')->with('data',$data['data']);
        // return $data['data'];
    }

    public function ever_profile()
    {
        $id = Session::get('user_id');
        $profile_data = DB::table('users')
                        ->join('profiles','profiles.user_id','=','users.user_id')
                        ->where('users.user_id',$id)
                        ->select('profiles.*','users.name','users.name','users.image','users.email')
                        ->get();
        if(count($profile_data)>0)
        {
            $data['data'] = $profile_data;
            $data['nodata'] = false;
            return view('profile')->with('data',$data['data'])->with('error',$data['nodata']);
        }
        else
        {
            $data['nodata'] = true;
            return view('profile')->with('error',$data['nodata']);
        }
        
        // return view('student.studentprofile')->with('data',$data['data']);
        // return $data['data'];
    }

    public function ever_editprofile()
    {
        $id = Session::get('user_id');
        $profile_data = DB::table('users')
                        ->join('profiles','profiles.user_id','=','users.user_id')
                        ->where('users.user_id',$id)
                        ->select('profiles.*','users.name','users.name','users.image','users.email')
                        ->get();
        if(count($profile_data)>0)
        {
            $data['data'] = $profile_data;
            $data['nodata'] = false;
            return view('editprofile')->with('data',$data['data'])->with('error',$data['nodata']);
        }
        else
        {
            $data['nodata'] = true;
            return view('editprofile')->with('error',$data['nodata']);
        }
        
        // return view('student.studentprofile')->with('data',$data['data']);
        // return $data['data'];
    }

    public function ever_saveprofile($id,Request $request)
    {
        $name = $request->name;
        $bdate = $request->bdate;
        $phoneno= $request->mobile;
        $gender = $request->gender;
        $email = $request->email;

        $request->validate(
            [
                'bdate' => 'required | Date',
                'email' => 'required | email',
                'name'  => 'required',
                'mobile'=> 'required',
            ]
            );
        DB::table('profiles')
            ->where('id',$id)
            ->update(['phoneno'=>$phoneno,'gender' => $gender,'bdate'=>$bdate]);
        DB::table('users')
            ->where('user_id',Session::get('user_id'))
            ->update(['name'=>$name,'email' => $email]);

        return back();
    }
}
