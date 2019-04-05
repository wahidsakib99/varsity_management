@extends('mainlayout')
@section('title')
Teacher| Upload
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container">
    <div id="msg" style="display: none"></div>
    <div class="container">
        <h3 id="subject" class="float-left"></h3>
        <button class="btn float-right" style="margin-top: 4px;" onclick="show_out_of_modal()"><i class="fas fa-cog"></i></button>
        <br>
        <hr>
        <ul class="nav nav-tabs">
            <li id="checkall" class="nav-item"><a class="nav-link"><input type="checkbox" onchange="check()" id="checkinput"></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Subject<span class="caret"></span></a>
                <ul class="dropdown-menu" id="subjectslist" style="max-height: 200px;overflow-y: auto">
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#student">Student</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#retake" onclick="getretakestudent()">Retake</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#update" onclick="getupdatestudent()">Update</a></li>
        </ul>
        <div class="tab-content">
            <div id="student" class="tab-pane fade show active" style="background: #fff">
                <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                    <table id="studenttabtable" class="table table-sm text-center">
                        <thead>
                        </thead>
                        <tbody id="studenttabtbody">
                        </tbody>
                    </table>
                    <center> <button type="button" class="btn btn-success" id="upload" onclick="uploadresult()"><span
                                class="glyphicon glyphicon-ok-sign"></span>&nbsp;Upload</button>
                </div>
            </div>
            {{-- RETAKE TAB --}}
            <div id="retake" class="tab-pane fade" style="background: #fff">
                <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                    <table id="retaketabtable" class="table table-sm text-center">
                        <thead>
                        </thead>
                        <tbody id="retaketabtbody">
                        </tbody>
                    </table>
                    <center> <button type="button" class="btn btn-success" id="retakeupload" onclick="retakeuploadresult()"><span
                                class="glyphicon glyphicon-ok-sign"></span>&nbsp;Upload</button>
                </div>
            </div>
            {{-- UPDATE TAB --}}
            <div id="update" class="tab-pane fade" style="background: #fff">
                <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                    <table id="updatetabtable" class="table table-sm text-center">
                        <thead>
                        </thead>
                        <tbody id="updatetabtbody">  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="out_of_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Customize Total Marks</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <b>Attendance:</b><br>
                    <p style="font-size: 13px;">Set Total number for attendance</p>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control form-control-sm" id="attndce"  onchange="set_total()" onkeyup="set_total()">
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <b>Report or Assignment:</b><br>
                  <p style="font-size: 13px;">Set Total number for Report or Assignment</p>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control form-control-sm" id="rora"  onkeyup="set_total()" onchange="set_total()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                  <b>Class Test:</b><br>
                  <p style="font-size: 13px;">Set Total number for Class Test</p>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control form-control-sm" id="ct"  onkeyup="set_total()" onchange="set_total()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                  <b>Mid Term:</b><br>
                  <p style="font-size: 13px;">Set Total number for Mid Term</p>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control form-control-sm" id="mid"  onkeyup="set_total()" onchange="set_total()">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                  <b>Final:</b><br>
                  <p style="font-size: 13px;">Set Total number for Final</p>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control form-control-sm"  id="final" onkeyup="set_total()" onchange="set_total()">
                </div>
            </div>
            <div class="row float-right">
                <div class="col-md-6">
                  <b>Total:</b><br>
                </div>
                <div class="col-md-3" id="total_mark">
                </div>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save_button" onclick="save_out_of()">Save changes</button>
            </div>
          </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script> 
<script>

    function check() {
        var check_all_button = document.getElementById('checkinput');
        var checks = document.getElementsByName('id[]');
        if (check_all_button.checked) {
            for (var i = 0; i < checks.length; i++) {
                checks[i].checked = true;
            }
        } else {
            for (var i = 0; i < checks.length; i++) {
                checks[i].checked = false;
            }
        }
    }

    function hidemsg() {
        var n = document.getElementById('msg');
        n.style.display = 'none';
    }

    $('document').ready(function () {
        $.ajax({
            url: 'getsubjects',
            method: 'get',
            success: function (data) {
                if (data['error'] === false) {
                    if (data['nodata'] === false) {
                        var datas = data['data'];
                        var list = '';
                        for (var i = 0; i < datas.length; i++) {
                            list = list + "<li onclick='getstudents(" + datas[i].sec_id + "," + datas[i].sub_id + ")'><a class='nav-link'>" + datas[i].subname + ' - (' + datas[i].secname + ")</a></li>";
                        }
                        document.getElementById('subjectslist').innerHTML = list;
                        document.getElementById('studenttabtable').style.display = ' ';
                        document.getElementById('upload').style.display = ' ';
                        getstudents(datas[0].sec_id, datas[0].sub_id);
                    } else {
                        var errors = "<div class='alert alert-danger'><strong></strong>You have not selected as teacher for any subject.</div>";
                        document.getElementById('studenttabtable').style.display = 'none';
                        document.getElementById('msg').innerHTML = errors;
                        document.getElementById('msg').style.display = 'block';
                        document.getElementById('upload').style.display = 'none';
                        var hide = setTimeout(hidemsg, 4000);
                    }


                } else {
                    var errors = "<div class='alert alert-danger'><strong></strong>Session is not active. Contact Admin.</div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('studenttabtable').style.display = 'none';
                    document.getElementById('upload').style.display = 'none';
                    document.getElementById('msg').style.display = 'block';
                    var hide = setTimeout(hidemsg, 4000);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
    var section_id_global;
    var subject_id_global;
    var student_id_global = [];

    function getstudents(section_id, subject_id) {
        section_id_global = section_id;
        subject_id_global = subject_id;
        $.ajax({
            url: 'getstudents',
            method: 'get',
            data: {
                section: section_id,
                subject: subject_id
            },
            success: function (data) {
                if (data['user'] === true) {
                    document.getElementById('subject').innerHTML = data['subject'] + ' - (' + data['section'] + ')';
                    if (data['nodata'] === false) {
                        var datas = data['student'];
                        var tablerow = '';
                        for (var i = 0; i < datas.length; i++) {
                            //ASSIGNING STUDENT ID TO 'student_id_global' FOR BETTER ERROR DETECTION
                            student_id_global[i] = datas[i].student_id;
                            tablerow = tablerow + "<tr><td><input type='checkbox' name='id[]' value=" + datas[i].id + "></td><td>" + datas[i].name + "</td><td>" + datas[i].student_id + "</td><td><input type='number' class='form-control form-control-sm' name='attendance[]' placeholder='Attendance("+data['out_of'].attendance+")'></td><td><input type='number' class='form-control form-control-sm' name='rora[]' placeholder='Report("+data['out_of'].rora+")'></td><td><input type='number' class='form-control form-control-sm' name='ct[]' placeholder='CT ("+data['out_of'].ct+")'></td><td><input type='number' class='form-control form-control-sm' name='mid[]' placeholder='Mid("+data['out_of'].mid+")'></td><td><input type='number' class='form-control form-control-sm' name='final[]' placeholder='Final ("+data['out_of'].final+")'></td></tr>";
                        }
                        document.getElementById('studenttabtbody').innerHTML = tablerow;
                        document.getElementById('studenttabtable').style.display = '';
                        document.getElementById('upload').style.display = 'block';
                    } else {
                        var errors = "<div class='alert alert-danger'><strong></strong>Nothing Pending</div>";
                        document.getElementById('msg').innerHTML = errors;
                        document.getElementById('studenttabtable').style.display = 'none';
                        document.getElementById('msg').style.display = 'block';
                        document.getElementById('upload').style.display = 'none';
                        var hide = setTimeout(hidemsg, 4000);
                    }
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function grade_checker(attendance, rora, ct, mid, final) {
        var result = [2];
        var sum = parseFloat(attendance) + parseFloat(rora) + parseFloat(ct) + parseFloat(mid) + parseFloat(final);
        if (sum < 40) // 0 - 40
        {
            result[0] = 'F';
            result[1] = '0.0';
        } else if (sum < 45 && sum > 39) // 40 - 44
        {
            result[0] = 'D';
            result[1] = '2.0';
        } else if (sum < 50 && sum > 44) // 45 - 49
        {
            result[0] = 'C';
            result[1] = '2.25';
        } else if (sum < 55 && sum > 49) // 50 - 54
        {
            result[0] = 'C+';
            result[1] = '2.50';
        } else if (sum < 60 && sum > 54) // 55 - 59
        {
            result[0] = 'B-';
            result[1] = '2.75';
        } else if (sum < 65 && sum > 59) // 60 - 64
        {
            result[0] = 'B';
            result[1] = '3.00';
        } else if (sum < 70 && sum > 64) // 65 - 69
        {
            result[0] = 'B+';
            result[1] = '3.25';
        } else if (sum < 75 && sum > 69) // 70 - 74
        {
            result[0] = 'A-';
            result[1] = '3.50';
        } else if (sum < 80 && sum > 74) // 75 - 79
        {
            result[0] = 'A';
            result[1] = '3.75';
        } else if (sum > 79 && sum < 101) // 80 - 100
        {
            result[0] = 'A+';
            result[1] = '4.00';
        }

        return result;
    }

    function uploadresult() {
        var id = document.getElementsByName('id[]');
        var temp_attndce = document.getElementsByName('attendance[]');
        var temp_rora = document.getElementsByName('rora[]');
        var temp_ct = document.getElementsByName('ct[]');
        var temp_mid = document.getElementsByName('mid[]');
        var temp_final = document.getElementsByName('final[]');
        var checked_id = [];
        var attendance = [];
        var rora = []; // REPORT OR ASSIGNMENT
        var ct = [];
        var mid = [];
        var final = [];
        var grade = [];
        var cgpa = [];
        var failed = [];
        var count_helper = 0;
        var failed_count = 0;
        var loop_tracker = 0; // FOR CHECKING CHECKED ITEMS

        $.ajax({
            url:'get_max_mark/'+subject_id_global+'/'+section_id_global,
            method:'get',
            success:function(data)
            {
                for (var i = 0; i < id.length; i++) {
                    if (id[i].checked === true) {
                        //CHECKED
                        if (parseFloat(temp_attndce[i].value) >= 0 && parseFloat(temp_attndce[i].value) <= data['out_of'].attendance && parseFloat(temp_rora[i].value) >= 0 && parseFloat(temp_rora[i].value) <= data['out_of'].rora && parseFloat(temp_ct[i].value) >= 0 && parseFloat(temp_ct[i].value) <= data['out_of'].ct && parseFloat(temp_mid[i].value) >= 0 && parseFloat(temp_mid[i].value) <= data['out_of'].mid && parseFloat(temp_final[i].value) >= 0 && parseFloat(temp_final[i].value) <= data['out_of'].final && temp_attndce[i].value != ' ' && temp_rora[i].value != ' ' && temp_ct[i].value != ' ' && temp_mid[i].value != ' ' && temp_final[i].value != ' ') {
                            checked_id[count_helper] = id[i].value;
                            attendance[count_helper] = temp_attndce[i].value;
                            rora[count_helper] = temp_rora[i].value;
                            ct[count_helper] = temp_ct[i].value;
                            mid[count_helper] = temp_mid[i].value;
                            final[count_helper] = temp_final[i].value;

                            var result = grade_checker(attendance, rora, ct, mid, final);
                            grade[count_helper] = result[0]; // 0 for grade
                            cgpa[count_helper] = result[1]; // 1 for result;
                            count_helper++;
                        } else {
                            failed[failed_count] = 'Error Found for ID <strong>' + student_id_global[i] + '</strong>';
                            failed_count++;
                        }
                        loop_tracker++;
                    }

                }
                if (loop_tracker > 0) {
                    if (failed.length > 0) {
                        var error_start = "<div class='alert alert-danger'><strong></strong><ul>";
                        var error_end = "</ul></div>";
                        var errors = ' ';
                        for (var i = 0; i < failed.length; i++) {
                            errors = errors + "<li>" + failed[i] + "</li>";

                        }
                        document.getElementById('msg').innerHTML = error_start + errors + error_end + '.';
                        document.getElementById('msg').style.display = 'block';
                        var hide = setTimeout(hidemsg, 5000);
                    } else {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: 'postresultregular',
                            method: 'post',
                            data: {
                                id: checked_id,
                                attendance: attendance,
                                rora: rora,
                                ct: ct,
                                mid: mid,
                                final: final,
                                grade: grade,
                                cgpa: cgpa,
                                section: section_id_global,
                                subject: subject_id_global
                            },
                            success: function (data) {
                                if (data['update'] === true) {
                                    var errors = "<div class='alert alert-success'><strong>Success</strong></div>";
                                    document.getElementById('msg').innerHTML = errors;
                                    document.getElementById('msg').style.display = 'block';
                                    var hide = setTimeout(hidemsg, 4000);
                                } else {
                                    var errors = "<div class='alert alert-danger'><strong>Failed</strong></div>";
                                    document.getElementById('msg').innerHTML = errors;
                                    document.getElementById('msg').style.display = 'block';
                                    var hide = setTimeout(hidemsg, 4000);
                                }
                                getstudents(section_id_global, subject_id_global);
                            },
                            error: function (e) {
                                console.log(e);
                            },
                        });

                    }
                } else {
                    var errors = "<div class='alert alert-danger'><strong></strong>Please Select At least 1 row.</div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    var hide = setTimeout(hidemsg, 4000);
                }
            },
            error:function(e)
            {
                console.log(e);
            },
        })


    }
    var retake_attendance = [];
    var retake_rora = [];
    var retake_ct = [];
    var retake_mid = [];
    var retake_student_id = [];

    function getretakestudent() {

        $.ajax({
            url: 'getretakestudentresult',
            method: 'get',
            data: {
                section: section_id_global,
                subject: subject_id_global
            },
            success: function (data) {
                if (data['user'] === true) {
                    document.getElementById('subject').innerHTML = data['subject'] + ' - (' + data['section'] + ')';
                    if (data['nodata'] === false) {
                        var datas = data['student'];
                        var tablerow = '';
                        for (var i = 0; i < datas.length; i++) {
                            retake_attendance[i] = datas[i].attendance;
                            retake_rora[i] = datas[i].rora;
                            retake_ct[i] = datas[i].ct;
                            retake_mid[i] = datas[i].mid;
                            retake_student_id[i] = datas[i].student_id;
                            //ASSIGNING STUDENT ID TO 'student_id_global' FOR BETTER ERROR DETECTION
                            student_id_global[i] = datas[i].student_id;
                            tablerow = tablerow + "<tr><td><input type='checkbox' name='retakeid[]' value=" + datas[i].id + "></td><td>" + datas[i].name + "</td><td>" + datas[i].student_id + "</td><td><input type='text' class='form-control form-control-sm' name='retakeattendance[]' placeholder='Attendance (" + datas[i].attendance + ")'readonly></td><td><input type='text' class='form-control form-control-sm' name='rora[]' placeholder='Report (" + datas[i].rora + ")' readonly></td><td><input type='text' class='form-control form-control-sm' name='ct[]' placeholder='C.T (" + datas[i].ct + ")' readonly></td><td><input type='text' class='form-control form-control-sm' name='mid[]' placeholder='Mid Term (" + datas[i].mid + ")' readonly></td><td><input type='number' class='form-control form-control-sm' name='retakefinal[]' placeholder='Final'></td></tr>";
                        }
                        document.getElementById('retaketabtbody').innerHTML = tablerow;
                        document.getElementById('retaketabtable').style.display = '';
                        document.getElementById('retakeupload').style.display = 'block';
                    } else {
                        var errors = "<div class='alert alert-danger'><strong></strong>Nothing Pending</div>";
                        document.getElementById('msg').innerHTML = errors;
                        document.getElementById('retaketabtable').style.display = 'none';
                        document.getElementById('msg').style.display = 'block';
                        document.getElementById('retakeupload').style.display = 'none';
                        var hide = setTimeout(hidemsg, 4000);
                    }
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    }

    function retakeuploadresult() {

        var retakeid = document.getElementsByName('retakeid[]');
        var temp_final = document.getElementsByName('retakefinal[]');
        var failed = [];
        var count_helper = 0;
        var failed_count = 0;
        var checked_id = [];
        var attendance = [];
        var rora = [];
        var mid = [];
        var ct = [];
        var final = [];
        var grade = [];
        var cgpa = [];
        var loop_tracker = 0;
        for (var i = 0; i < retakeid.length; i++) {
            if (retakeid[i].checked) {
                if (parseFloat(temp_final[i].value) >= 0 && parseFloat(temp_final[i].value) && temp_final[i].value != ' ') {
                    checked_id[count_helper] = retakeid[i].value;
                    final[count_helper] = temp_final[i].value;

                    var result = grade_checker(retake_attendance[i], retake_rora[i], retake_ct[i], retake_mid[i], final[i]);
                    grade[count_helper] = result[0];
                    cgpa[count_helper] = result[1];
                } else {
                    failed[failed_count] = "Error Found For ID <strong>" + retake_student_id[i] + "</strong>";
                    failed_count++;
                }
                loop_tracker++;
            }
        }

        if (loop_tracker > 0) {
            if (failed.length > 0) {
                var error_start = "<div class='alert alert-danger'><strong></strong><ul>";
                var error_end = "</ul></div>";
                var errors = ' ';
                for (var i = 0; i < failed.length; i++) {
                    errors = errors + "<li>" + failed[i] + "</li>";

                }
                document.getElementById('msg').innerHTML = error_start + errors + error_end + '.';
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 5000);
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: 'postresultretake',
                    method: 'post',
                    data: {
                        id: checked_id,
                        attendance: attendance,
                        rora: rora,
                        ct: ct,
                        mid: mid,
                        final: final,
                        grade: grade,
                        cgpa: cgpa
                    },
                    success: function (data) {
                        console.log(data);
                        if (data['update'] === true) {
                            var errors = "<div class='alert alert-success'><strong>Success</strong></div>";
                            document.getElementById('msg').innerHTML = errors;
                            document.getElementById('msg').style.display = 'block';
                            var hide = setTimeout(hidemsg, 4000);
                        } else {
                            var errors = "<div class='alert alert-danger'><strong>Failed</strong></div>";
                            document.getElementById('msg').innerHTML = errors;
                            document.getElementById('msg').style.display = 'block';
                            var hide = setTimeout(hidemsg, 4000);
                        }
                        getretakestudent();
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });

            }
        } else {
            var errors = "<div class='alert alert-danger'><strong></strong>Please Select At least 1 row.</div>";
            document.getElementById('msg').innerHTML = errors;
            document.getElementById('msg').style.display = 'block';
            var hide = setTimeout(hidemsg, 4000);
        }
    }

    function getupdatestudent() {
        $.ajax({
            url: 'getupdatestudent',
            method: 'get',
            data: {
                section: section_id_global,
                subject: subject_id_global
            },
            success: function (data) {
                var update_reg_rec = '';
                var update_ret = '';
                if (data['user'] === true) {
                    if (data['nodata'] === false) {
                        if (data['regrec'].length > 0) {
                            var datas = data['regrec'];
                            for (var i = 0; i < data['regrec'].length; i++) {
                                var sum = parseFloat(datas[i].attendance) + parseFloat(datas[i].rora) + parseFloat(datas[i].ct) + parseFloat(datas[i].mid) + parseFloat(datas[i].final);
                                update_reg_rec = update_reg_rec + "<tr><td>" + datas[i].name + "</td><td>" + datas[i].student_id + "</td><td><input type='number' class='form-control form-control-sm' placeholder='Total (" + sum + ")' readonly></td><td><input type='text' class='form-control form-control-sm' placeholder='Grade (" + datas[i].grade + ")' readonly></td><td><input type='text' class='form-control form-control-sm' placeholder='CGPA (" + datas[i].cgpa + ")' readonly></td><td><button class='btn btn-danger' onclick='regrec(" + datas[i].id + ")'>Restore</button></td></tr>";
                            }
                        } else {
                            //NO REGULAR OR RECOURSE STUDENT
                        }
                        if (data['ret'].length > 0) {
                            var datas = data['ret'];
                            for (var i = 0; i < data['ret'].length; i++) {
                                update_ret = update_ret + "<tr><td>" + datas[i].name + "</td><td>" + datas[i].student_id + "</td><td><input type='number' class='form-control form-control-sm' placeholder='Total(" + sum + ")' readonly></td><td><input type='text' class='form-control form-control-sm' placeholder='Grade (" + datas[i].grade + ")' readonly></td><td><input type='text' class='form-control form-control-sm' placeholder='CGPA (" + datas[i].cgpa + ")' readonly></td><td><button class='btn btn-danger' onclick='ret(" + datas[i].id + ")'>Restore</button></td></tr>";
                            }
                        } else {
                            // NO RETAKE STUDENT
                        }
                        document.getElementById('updatetabtbody').innerHTML = update_reg_rec + update_ret;
                        document.getElementById('updatetabtable').style.display = '';
                    } else {
                        //NO DATA TRUE
                        document.getElementById('updatetabtable').style.display = 'none';
                        var errors = "<div class='alert alert-danger'><strong></strong>Nothing Pending</div>";
                        document.getElementById('msg').innerHTML = errors;
                        document.getElementById('msg').style.display = 'block';
                        var hide = setTimeout(hidemsg, 4000);
                    }
                } else {
                    //USER TRIED TO HACK
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    }

    function regrec(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'restore_regrec/' + id,
            method: 'post',
            success: function (data) {
                getupdatestudent();
                getstudents(section_id_global, subject_id_global);
            },
            error: function (e) {
                console.log(e);
            },
        });
    }

    function ret(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'restore_ret/' + id,
            method: 'post',
            success: function (data) {
                getupdatestudent();
                getstudents(section_id_global, subject_id_global);
            },
            error: function (e) {
                console.log(e);
            },
        });
    }
    function show_out_of_modal()
    {
        $.ajax(
            {
                url:'getout_of_data',
                method:'get',
                data:{section_id:section_id_global,subject_id:subject_id_global},
                success:function(data)
                {
                    
                    document.getElementById('attndce').value = data['data'].attendance;
                    document.getElementById('rora').value = data['data'].rora;
                    document.getElementById('ct').value = data['data'].ct;
                    document.getElementById('mid').value = data['data'].mid;
                    document.getElementById('final').value = data['data'].final;
                    set_total();
                },
                error:function(e)
                {
                    console.log(e);
                },
            }
        );
        // document.getElementById('total_mark').innerHTML = total;
        $('#out_of_modal').modal('toggle');
    }
    function set_total()
    {
        var attendance = document.getElementById('attndce').value;
        var rora = document.getElementById('rora').value;
        var ct = document.getElementById('ct').value;
        var mid = document.getElementById('mid').value;
        var final = document.getElementById('final').value;

        var total = parseInt(attendance) + parseInt(rora) + parseInt(ct) +parseInt( mid )  + parseInt(final) ;
        if(total === 100)
        {
            document.getElementById('total_mark').innerHTML = total;
            document.getElementById('save_button').disabled = false;
        }
        else
        {
            document.getElementById('total_mark').innerHTML = "<p style='color:red;'>"+total+"</p>";
            document.getElementById('save_button').disabled = true;
        }
    }

    function save_out_of()
    {
        var attendance = document.getElementById('attndce').value;
        var rora = document.getElementById('rora').value;
        var ct = document.getElementById('ct').value;
        var mid =  document.getElementById('mid').value;
        var final = document.getElementById('final').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'save_out_of',
            method:'post',
            data:{section_id:section_id_global,subject_id:subject_id_global,attendance:attendance,rora:rora,ct:ct,mid:mid,final:final},
            success:function(data)
            {
                if(data['update'] === true)
                {
                    getstudents(section_id_global,subject_id_global);
                    $('#out_of_modal').modal('toggle');
                }
            },
            error:function(e)
            {

            },
        });

    }
    </script>