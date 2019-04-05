@extends('mainlayout')
@section('title')
Admin | Dashboard
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="/css/admindashboard.css">
    <div class="container">
        <h2 class="card-title">Welcome <span>Admin</span></h2>
        <!-- OVERVIEW TILE -->
        <div>
            <h2 class="text-muted text-center">Overview</h2>
            <hr>
            <!-- TILES COMES HERE -->
            <div class="flex-items container row">
                <div id="firstitem" class="  text-white items card shadow col-md-3">
                    <h5>Total Student</h5>
                    <h6 id="total_student">0</h6>
                </div>
                <div id="seconditem" class="  text-white items card shadow col-md-3">
                    <h5>Session</h5>
                    <h6 id="session"></h6>
                </div>
                <div id="thirditem" class="shadow  text-white card items hoverable col-md-3">
                    <h5></h5>
                    <h6></h6>
                </div>
            </div>
        </div>

        <br>
        <!-- QUICK UPDATE TILES -->
        <div>
            <h2 class="text-muted text-center">Quick Update</h2>
            <hr>
            <!-- TILES COME HERE -->
            <div class="flex-items container">
                <div class="control-table-size">
                    <!-- CONTROLLING WHOLE MAX STUDENT TABLE -->
                    <div class="container">
                        <h4 class="text-center text-muted sticky-top bg-white">Max Student</h4>
                        <!-- TABLE FOR MAX STUDENT -->
                        <div>
                            <table class="table table-sm table-wrapper-scroll-y" id="max_student_table">
                                <thead>
                                    <tr class="table-info text-center">
                                        <th>Section</th>
                                        <th>Student</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="max_student_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="control-table-size">
                        <div class="container">
                            <h4 class="text-center text-muted sticky-top bg-white">Per Credit Value</h4>
                            <!-- PER CREDIT VALUE TABLE HERE -->
                            <table class="table table-sm table-wrapper-scroll-y"  id="per_credit_table">
                                <thead>
                                    <tr class="table-info text-center">
                                        <th>Semester</th>
                                        <th>Regular</th>
                                        <th>Retake</th>
                                        <th>Recourse</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="per_credit_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>


                </div>
            </div>
        </div>

        <br>
        <!-- TEACHER & STUDENT TABLE -->
        <div>
            <h2 class="text-muted text-center">Pre-requisite</h2 >
            <hr>
            <div class="flex-items container">
                <div>
                    <div class="control-table-size">
                        <div class="container">
                            <h4 class="text-center text-muted sticky-top bg-white">Set Pre-requisite</h4>
                            <div>
                                <!-- SEMESTER SELECTION HERE -->
                                <select class="form-control form-control-sm sticky-top bg-white" id="pre_req_semester" onchange="set_pre_req(this.value)">
                                </select>
                            </div>
                            <br>
                            <!-- PREREQUISITE TABLE HERE -->
                            <table class="table table-sm table-wrapper-scroll-y" id="prereq_table">
                                <thead>
                                    <tr class="table-info text-center">
                                        <th>Subject</th>
                                        <th>Current PreR.</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody id="prereq_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- STUDENT TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="per" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        Semester: <strong id="percreditsemester"></strong>
                        <br>
                        <label><b>Regular</b>:</label>&nbsp;<input type="text" class="form-control form-control-sm" id="regular">
                        <label><b>Retake</b>:</label>&nbsp;<input type="text" class="form-control form-control-sm" id="retake">
                        <label><b>Recourse</b>:</label>&nbsp;<input type="text" class="form-control form-control-sm" id="recourse">
                        <input type="hidden" id="perid">
                        <div id="updatemsg" style="display: none">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="percreditupdate()">Update</button>
                </div>
            </div>
        </div>
    </div>
{{-- MODAL OF MAX STUDENT --}}
    <div class="modal fade" id="max" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="max_section"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    Current Max: <strong id="cr_max"></strong>
                    <br>
                    <label><b>Update</b>:</label>&nbsp;<input type="number" class="form-control form-control-sm" id="updated_max">
                    <div id="maxmsg" style="display: none"></div>
                </div>
                <input type="hidden" name="max_id" id="max_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="update_max()">Update</button>
            </div>
        </div>
    </div>
</div>
{{-- MODAL OF PREREQUISITE --}}
<div class="modal fade" id="prereq_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container">
                Semester: <strong id="prereq_semester"></strong>
                <br>
                <label><b>Subject </b>:</label>&nbsp;<strong id="subject"></strong> <br>
                <label><b>Current PreR. </b>:</label>&nbsp;<strong id="crnt_prereq"></strong><br>
                <label><b>Update</b>:</label>&nbsp;<select  id="update_prereq" class="form-control form-control-sm"></select>
                <input type="hidden" id="hidmainsub">
                <input type="hidden"  id="hidsem">
                <div id="prereqmsg" style="display: none">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="deleteprereq()">Delete</button>
            <button type="button" class="btn btn-primary" onclick="update_pre_requisite()">Update</button>
        </div>
    </div>
</div>
</div>
<footer style="height: 100px;">
    
</footer>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script> 
<script>
    function sup(name) {
        if (name === '1')
            return name + '<sup>st</sup>';
        else if (name === '2')
            return name + '<sup>nd</sup>';
        else if (name === '3')
            return name + '<sup>rd</sup>';
        else
            return name + '<sup>th</sup>';
    }
    function sup_temp(name)
    {
        if (name === '1')
            return name + 'st';
       else if (name === '2')
            return name + 'nd';
       else if (name === '3')
            return name + 'rd';
       else
            return name +'th';
   }

    function max_hidemsg() {
        document.getElementById('maxmsg').style.display = 'none';
    }
    function hideprereqmsg()
    {
        document.getElementById('prereqmsg').style.display = 'none';
    }
    function updatemsg()
    {
        document.getElementById('updatemsg').style.display = 'none';
    }
    $('document').ready(function () {
        first_row();
        second_row();
        third_row();
    });

    function first_row() {
        var total_student = document.getElementById('total_student');
        var session = document.getElementById('session');
        $.ajax({
            url: 'getfirstrow',
            method: 'get',
            success: function (data) {
                total_student.innerHTML = data['total_student'];
                session.innerHTML = data['session_name'].year + ' ' + data['session_name'].month;
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function second_row() {
        var max_student_table = document.getElementById('max_student_table');
        var max_student_tbody = document.getElementById('max_student_tbody');

        $.ajax({
            url: 'getsecondrow',
            method: 'get',
            success: function (data) {
                var max_student = data['max_student_included'];
                if (max_student.length > 0) {
                    var table_row = '';
                    for (var i = 0; i < max_student.length; i++) {
                        table_row = table_row + "<tr class='text-center'><td>" + max_student[i].name + "</td><td>" + max_student[i].max_student + "</td><td style='cursor: pointer'><i class='fas fa-pen' style='color: rgb(54, 88, 59)' onclick='show_update_max(" + max_student[i].id + ")'></i></td></tr>";
                    }
                    max_student_tbody.innerHTML = table_row;
                } else {
                    //MAX STUDENT E KNO DATA NAI
                    console.log('no data');
                }

                var per_credit = data['per_credit_value'];
                if (per_credit.length > 0) {
                    var table_row = '';
                    for (var i = 0; i < per_credit.length; i++) {
                        table_row = table_row + "<tr class='text-center'><td>" + sup(per_credit[i].name) + "</td><td>" + per_credit[i].regular_values + " /=</td><td>" + per_credit[i].retake_values + " /=</td><td>" + per_credit[i].recourse_values + " /=</td><td style='cursor: pointer'><i class='fas fa-pen' style='color: rgb(54, 88, 59)' onclick='update_per(" + per_credit[i].id + ")'></i></td></tr>";
                    }
                    document.getElementById('per_credit_tbody').innerHTML = table_row;

                } else {

                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function third_row() {
        var semester_dropdown = document.getElementById('pre_req_semester');
        $.ajax({
            url: 'getsemester',
            method: 'get',
            success: function (data) {
                if (data.length > 0) {
                    var table_row = '';
                    for (var i = 0; i < data.length; i++) {
                        table_row = table_row + "<option value='" + data[i].id + "'>" + sup(data[i].name) + " Semester</option>";
                    }
                    semester_dropdown.innerHTML = table_row;
                    set_pre_req(data[0].id);
                } else {
                    //NO SEMSETER
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function set_pre_req(id) {
        $.ajax({
            url: 'getprereq/' + id,
            method: 'get',
            success: function (data) {
                if (data['nodata'] === false) {
                    var tablerow = '';
                    for (var i = 0; i < data['main_sub'].length; i++) {
                        tablerow = tablerow + "<tr class='text-center'><td>" + data['main_sub'][i] + "</td><td>" + data['prereq'][i] + "</td><td style='cursor: pointer'><i class='fas fa-pen' style='color: rgb(54, 88, 59)' onclick='update_prereq("+data['id'][i]+","+data['type'][i]+")'></i></td></tr>";
                    }
                    document.getElementById('prereq_tbody').innerHTML = tablerow;
                } else {
                    document.getElementById('prereq_tbody').innerHTML = '';
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function show_update_max(id) {
        $.ajax({
            url: 'show_update_max/' + id,
            method: 'get',
            success: function (data) {
                document.getElementById('max_section').innerHTML = data[0].name;
                document.getElementById('cr_max').innerHTML = data[0].max_student;
                document.getElementById('max_id').value = data[0].id;
                $('#max').modal('show');
            },
            error: function (e) {
                console.log(e);
            },
        });

    }

    function update_max() {
        var updated_value = document.getElementById('updated_max').value;
        if (updated_value !== "" && updated_value >= 0 && updated_value <= 70) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'set_update_max',
                method: 'post',
                data: {
                    id: document.getElementById('max_id').value,
                    updated_value: updated_value
                },
                success: function (data) {
                    second_row();
                    $('#max').modal('hide');
                },
                error: function (e) {
                    console.log(e);
                },
            });
        } else {
            document.getElementById('maxmsg').innerHTML = "<p style='color:red'>Field Can not be null. Must be greater than 0 and smaller than 70 </p>";
            document.getElementById('maxmsg').style.display = '';
            var hide = setTimeout(max_hidemsg, 3000);
        }

    }

    function update_per(id)
    {
       var name = document.getElementById('percreditsemester');

        $.ajax({
            url:'showpervalues/'+id,
            method:'get',
            success:function(data)
            {
                name.innerHTML = sup(data[0].name);
                document.getElementById('regular').value = data[0].regular_values;
                document.getElementById('retake').value = data[0].retake_values;
                document.getElementById('recourse').value = data[0].recourse_values;
                document.getElementById('perid').value = data[0].id;
                $('#per').modal('show');
            },
            error:function(e)
            {
                console.log(e);
            }
        });
    }

    function percreditupdate()
    {
       var id = document.getElementById('perid').value;
       var regular = document.getElementById('regular').value;
       var retake = document.getElementById('retake').value;
       var recourse = document.getElementById('recourse').value;
       if(regular !== "" && retake !== "" && recourse !== "")
       {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url:'setupdatepercredit',
                    method:'post',
                    data:{id:id,regular:regular,retake:retake,recourse:recourse},
                    success:function(data)
                    {
                        $('#per').modal('hide');
                        second_row();
                    },
                    error:function(e)
                    {
                        console.log(e);
                    },
                }
            );
       }
       else
       {
        document.getElementById('updatemsg').innerHTML="<p style='color:red'>Invalid input</p>"
        document.getElementById('updatemsg').style.display='';
        var hide = setInterval(updatemsg,3000);
       }
    }
 function update_prereq(id,type)
 {
    semester = document.getElementById('prereq_semester');
    $.ajax({
        url:'getprereqsub',
        method:'get',
        data:{id:id,type:type},
        success:function(data)
        {  
            document.getElementById('prereq_semester').innerHTML = sup(data['selected_semester'].name);
            document.getElementById('subject').innerHTML = data['main_sub'].name;
            document.getElementById('hidmainsub').value = data['main_sub'].id;
            document.getElementById('hidsem').value = data['main_sub'].semester_id;
            if(type === 0)
            {

                document.getElementById('crnt_prereq').innerHTML='';
            }
            else if(type === 1)
            {
                document.getElementById('crnt_prereq').innerHTML=data['pre_req'];
            }
            var available_sems = data['semesters'];
            var optgrp='';
            var table_row = '';
            if(available_sems.length>0)
            {
                for(var i=0;i<available_sems.length;i++)
                {
                    table_row =table_row+"<optgroup label='"+sup_temp(available_sems[i].semname)+" Semester'>";
                   for(var j=0;j<data['subjects'].length;j++)
                   {
                       if(available_sems[i].semname === data['subjects'][j].semname)
                       {
                        table_row  = table_row + "<option value='"+data['subjects'][j].id+"'>"+data['subjects'][j].subname+"</option>";
                       }
                   }
                   table_row = table_row + "</optgroup>";
                }
                 document.getElementById('update_prereq').innerHTML = table_row;

            }
            else
            {
                //NO AVAILABLE SEMESTER
                document.getElementById('update_prereq').innerHTML = '';
            }
        },
        error:function(e)
        {
            console.log(e);
        },
    });
     $('#prereq_modal').modal('show');
 }

 function update_pre_requisite()
 {
    var main_sub = document.getElementById('hidmainsub').value;
    var prereq = document.getElementById('update_prereq').value;
    var semester = document.getElementById('hidsem').value;
    console.log('semester:'+semester);

    if(prereq !== "")
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
     $.ajax({
        url:'postupdateprereq',
        method:'post',
        data:{main_sub: main_sub,prereq:prereq},
        success:function(data)
        {
            if(data['update'] === true)
            {
                set_pre_req(semester);
                $('#prereq_modal').modal('hide');
            }
            else
            {
                document.getElementById('prereqmsg').innerHTML = "<p style='color:red'>Failed</p>";
                document.getElementById('prereqmsg').style.display = '';
                var hide = setInterval(hideprereqmsg,4000);
            }

        },
        error:function(e)
        {
            console.log(e);
        }
     });
    }
    else
    {
        document.getElementById('prereqmsg').innerHTML = "<p style='color:red'>Failed</p>";
                document.getElementById('prereqmsg').style.display = '';
                var hide = setInterval(hideprereqmsg,4000);
    }
    
 }
 function deleteprereq()
 {
     subject_id = document.getElementById('hidmainsub').value;
     var semester = document.getElementById('hidsem').value;

     $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
     $.ajax({
        url:'deleteprereq/'+subject_id,
        method:'post',
        success:function(data)
        {
            set_pre_req(semester);
            $('#prereq_modal').modal('hide');
        },
        error:function(e)
        {

        },
     });
 }
</script>