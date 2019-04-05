<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use DOMPDF;

class studentpaymentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_amount($credit,$type,$credit_values)
    {
        if($type == 0)
        {
            $credit = $credit*$credit_values->regular_values;
        }
        else if($type == 1)
        {
            $credit = $credit*$credit_values->retake_values;
        }
        else if($type == 2)
        {
            $credit = $credit*$credit_values->recourse_values;
        }
        return $credit;
    }
    public function index()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        if($active_session)
        {
            $check = DB::table('user_sections')->where('user_id',Session::get('user_id'))->where('section_id','!=',null)->first();
            if($check)
            {
            $datas = DB::table('sessiondatas')
                    ->join('subjects','sessiondatas.subject_id','=','subjects.id')
                    ->join('sections','sessiondatas.section_id','=','sections.id')
                    ->join('semesters','sessiondatas.semester_id','semesters.id')
                    ->where('sessiondatas.student_id',Session::get('user_id'))
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->where('sessiondatas.pending',1)
                    ->select('subjects.name as subname','subjects.credit as subcredit','sections.name','sessiondatas.type')
                    ->get();
            $profile = DB::table('profiles')
                    ->join('users','users.user_id','profiles.user_id')
                    ->where('profiles.user_id',Session::get('user_id'))
                    ->select('users.name','profiles.*')
                    ->get();
            $advisor = DB::table('user_sections')
                    ->join('sections','sections.id','user_sections.section_id')
                    ->join('users','users.user_id','sections.advisor_id')
                    ->where('user_sections.user_id',Session::get('user_id'))
                    ->select('users.name','sections.name as secname')
                    ->first();

                $advisor_name = $advisor->name;
                $user_section = $advisor->secname;


           

            $credit_values = DB::table('sections')
                    ->join('credit_values','credit_values.semester_id','sections.id')
                    ->where('sections.id',$check->section_id)
                    ->first();
            $sub_value= array();
            $total = 0;;
                for($i=0;$i<count($datas);$i++)
                {
                    $sub_value[$i] = $this->total_amount($datas[$i]->subcredit,$datas[$i]->type,$credit_values);
                    $total = $total + $this->total_amount($datas[$i]->subcredit,$datas[$i]->type,$credit_values);
                }
                $error = false;
            $previous_paid = DB::table('payments')->where('session_id',$active_session->id)->where('student_id',Session::get('user_id'))->first();
            $subject_count = count($datas)>0 ? 1:0;
            if($previous_paid)
            {
             
                $paid = true;
                return view('student.reciept')->with('datas',$datas)->with('profile',$profile)->with('advisor_name',$advisor_name)->with('sub_value',$sub_value)->with('total',$total)->with('error',$error)->with('secname',$user_section)->with('session',$active_session)->with('paid',$paid)->with('payment_data',$previous_paid)->with('subject_count',$subject_count);
            }
            else
            {
                $paid = false;
                return view('student.reciept')->with('datas',$datas)->with('profile',$profile)->with('advisor_name',$advisor_name)->with('sub_value',$sub_value)->with('total',$total)->with('error',$error)->with('secname',$user_section)->with('session',$active_session)->with('paid',$paid)->with('subject_count',$subject_count);
            }
                
            }
            else
            {
                $error = "You Have not enrolled for this session.";
                return view('student.reciept')->with('error',$error); 
            }           
        }
        else
        {
            $error = "Session is not active. Please Contact ADMIN";
            return view('student.reciept')->with('error',$error); 
        }
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

    public function paymentpage(Request $request,$total)
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $previous_paid = DB::table('payments')->where('session_id',$active_session->id)->where('student_id',Session::get('user_id'))->first();
        if($previous_paid)
        {
            return redirect('student/reciept');
        }
        else
        {
            return view('student.payment')->with('total',$total);
        }
         
    }
    public function paymentpost(Request $request,$total)
    {
        $client_card_number = $request->ycardNumber;


        $request->validate([
            'ycardNumber' => 'required | digits:15 | numeric | min:0 ',
        ]);
        $active_session = DB::table('sessions')->where('active',1)->first();
        $check = DB::table('user_sections')->where('user_id',Session::get('user_id'))->first();
        $datas = DB::table('sessiondatas')
                    ->join('subjects','sessiondatas.subject_id','=','subjects.id')
                    ->where('sessiondatas.student_id',Session::get('user_id'))
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->select('subjects.name as subname','subjects.credit as subcredit','sessiondatas.type')
                    ->get();
        $credit_values = DB::table('sections')
                    ->join('credit_values','credit_values.semester_id','sections.id')
                    ->where('sections.id',$check->section_id)
                    ->first();
        $sub_value= array();
        $total_server_side = 0;
                for($i=0;$i<count($datas);$i++)
                {
                    $total_server_side = $total_server_side + $this->total_amount($datas[$i]->subcredit,$datas[$i]->type,$credit_values);
                }
       if($total_server_side == $total)
       {
           $error = false;
           $previous_input = DB::table('payments')->where('session_id',$active_session->id)->where('student_id',Session::get('user_id'))->first();
           if(!$previous_input)
           {
            DB::table('payments')->insert([
                'student_id' => Session::get('user_id'),
                // 'client_id' => $client_card_number.'',
                'session_id' => $active_session->id,
                'reference' => str_random(15),
                'date' => date('Y-m-d'),
            ]);
             return redirect('/student/reciept');
           }
           else
           {
            return redirect('/student/reciept');
           }
            
       }
       else
       {
            $error = true;
            return back()->with('error',$error);
       }
       
    }

    public function makepdf()
    {
        $active_session = DB::table('sessions')->where('active',1)->first();
        $check = DB::table('user_sections')->where('user_id',Session::get('user_id'))->first();
         $datas = DB::table('sessiondatas')
                    ->join('subjects','sessiondatas.subject_id','=','subjects.id')
                    ->join('sections','sessiondatas.section_id','=','sections.id')
                    ->join('semesters','sessiondatas.semester_id','semesters.id')
                    ->where('sessiondatas.student_id',Session::get('user_id'))
                    ->where('sessiondatas.session_id',$active_session->id)
                    ->select('subjects.name as subname','subjects.credit as subcredit','sections.name','sessiondatas.type')
                    ->get();
            $profile = DB::table('profiles')
                    ->join('users','users.user_id','profiles.user_id')
                    ->where('profiles.user_id',Session::get('user_id'))
                    ->select('users.name','profiles.*')
                    ->get();
            $advisor = DB::table('user_sections')
                    ->join('sections','sections.id','user_sections.section_id')
                    ->join('users','users.user_id','sections.advisor_id')
                    ->where('user_sections.user_id',Session::get('user_id'))
                    ->select('users.name','sections.name as secname')
                    ->first();
            $advisor_name = $advisor->name;
            $user_section = $advisor->secname;

            $credit_values = DB::table('sections')
                    ->join('credit_values','credit_values.semester_id','sections.id')
                    ->where('sections.id',$check->section_id)
                    ->first();
            $sub_value= array();
            $total = 0;;
                for($i=0;$i<count($datas);$i++)
                {
                    $sub_value[$i] = $this->total_amount($datas[$i]->subcredit,$datas[$i]->type,$credit_values);
                    $total = $total + $this->total_amount($datas[$i]->subcredit,$datas[$i]->type,$credit_values);
                }
                $error = false;

            $previous_paid = DB::table('payments')->where('session_id',$active_session->id)->where('student_id',Session::get('user_id'))->first();
            if($previous_paid)
            {
                $paid = true;
            }
            else
            {
                $paid = false;             
            }
            $data['datas'] = $datas;
            $data['profile'] = $profile;
            $data['advisor_name'] = $advisor_name;
            $data['sub_value'] = $sub_value;
            $data['total'] = $total;
            $data['secname'] = $user_section;
            $data['session'] = $active_session;
            $data['payment_data'] = $previous_paid;
            $data['error'] = $error;
            $data['paid'] = $paid; 
            $pdf = DOMPDF::loadView('student.pdf',compact('data'));
            return $pdf->download('invoice.pdf');
             //return view('student.pdf')->with('datas',$datas)->with('profile',$profile)->with('advisor_name',$advisor_name)->with('sub_value',$sub_value)->with('total',$total)->with('error',$error)->with('secname',$user_section)->with('session',$active_session)->with('paid',$paid);
    }
}
