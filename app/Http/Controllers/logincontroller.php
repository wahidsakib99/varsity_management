<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class logincontroller extends Controller
{

    public function login(Request $request)
    {
        // $request->validate(
        //     [
        //         'Username' => 'numeric',
        //         'Password' => 'min:4',
        //     ]
        //     );
        $validating_right_user = DB::table('users')
                ->where('user_id',$request->input('Username'))
                ->where('password',$request->input('Password'))
                ->first();
        if($validating_right_user)
        {
            if($validating_right_user->active == 1)
            {
                Session::put('user_id',$validating_right_user->user_id);     
                if($validating_right_user->admin == 1)
                {
                    $user_role_admin = 1;
                    Session::put('admin',$user_role_admin);
                    return redirect('/dashboard');
                }
                if($validating_right_user->teacher == 1)
                {
                    $user_role_teacher =1;
                    Session::put('teacher',$user_role_teacher);
                    $advisor = DB::table('sections')->where('advisor_id',$request->input('Username'))->first();
                    if($advisor)
                    {
                        $user_role_advisor =1;
                        Session::put('advisor',$user_role_advisor);
                    }
                    return redirect('/teacher/dashboard');
                }
                if($validating_right_user->student == 1)
                {
                    $user_role_student =1;
                    Session::put('student',$user_role_student);
                    return redirect('/student/dashboard');
                }
                }else
                    return "Sorry, this user is blocked";
        }
        else 
        return redirect('/')->with('error','Incorrect User Name or Password');
        //return 'hello';
    }
    public function logout()
    {
     
         Session::flush();
         Session::save();
       // Artisan::call('cache:clear');
       // return redirect('/');
       return redirect('/');
    }

    public function register()
    {
        return view('registration');
    }


    public function register_user(Request $request)
    {
        $name = $request->uname;
        $u_id = $request->uid;
        $pass = $request->upass;
        $bdate = $request->bdate;
        $gender = $request->gender;
        $role = $request->role;
        $phone = $request->phone;
        $email = $request->email;
        $request->validate([
            'uname' => 'required',
            'email' => 'required|email',
            'upass' => 'required|digits:6',
            'bdate' => 'required|date',
            'gender'=> 'required|in:F,M',
            'role'  => 'required|in:1,2',
            'photo' => 'image',
        ]);

        $check = DB::table('users')->where('user_id',$u_id)->first();
        if(!$check)
        {
            $photo = $request->file('photo');
            $photo_new = rand().'.'.$photo->getClientOriginalExtension();
        $photo->move(public_path("images"),$photo_new);

        if($role == 1)
        {
            $request->validate([
                'uid'   => 'required|digits:13|numeric',
            ]);
            DB::table('users')->insert(
                [
                    'user_id' => $u_id,
                    'name'    => $name,
                    'email'   => $email,
                    'password' => $pass,
                    'image'  => $photo_new,
                    'admin'  => 0,
                    'teacher' => 0,
                    'student' => 1,
                    'active'  => 1

                ]
                );
        DB::table('profiles')->insert([
            'user_id'   => $u_id,
            'bdate'     => $bdate,
            'phoneno'   => $phone,
            'gender'    => $gender,
        ]);
        }
        else
            {
            $request->validate([
                    'uid'   => 'required|digits:4|numeric',
                ]);
                DB::table('users')->insert(
                    [
                        'user_id' => $u_id,
                        'name'    => $name,
                        'email'   => $email,
                        'password' => $pass,
                        'image'  => $photo_new,
                        'admin'  => 0,
                        'teacher' => 1,
                        'student' => 0,
                        'active'  => 1
                    ]
                    );
                DB::table('profiles')->insert([
                        'user_id'   => $u_id,
                        'bdate'     => $bdate,
                        'phoneno'   => $phone,
                        'gender'    => $gender,
                    ]);
            }
        }
        else
        {
            return back()->with('error','User Exist');
        }

       
    }
}
