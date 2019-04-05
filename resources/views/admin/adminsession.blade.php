@extends('mainlayout')
@section('title')
Admin | Session
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div id="msg"></div> <!-- DIV FOR SHOWING MESSAGES -->

<div class="container">
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal" onclick="setsemandtea()">Add
        Section</button>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#overview" onclick="showoverview()">Overview</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit" onclick="viewsessionsection()">Add
                Session</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#subject" onclick="assignteacher()">Assign
                Teacher</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#update" onclick="showassignedteacher()">Update
                Assigned Teacher</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#update_advisor" onclick="showassignedadvisor()">Update
                Assigned Advisor</a></li>
    </ul>
    <div class="tab-content">
        <div id="overview" class="tab-pane fade show active" style="background: #fff">
            <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                <table id="mytable" class="table table-sm">
                    <thead>
                        <tr class="table-info">
                            <th>Session</th>
                            <th>Total student enrolled</th>
                            <th>Status</th>
                            <th>Active/Disable</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="overviewtabtbody">
                    </tbody>
                </table>
            </div>
        </div>

        {{-- EDIT TAB --}}
        <div id="edit" class="tab-pane fade" style="background: #fff">
            <br>
            <h3 class="text-muted float-left">Add Session</h1>
                <br>
                <hr>
                <div style="margin-left: 5%; height: 200px; ">
                    <span>Month: </span><span> <select id='gMonth2' class="form-control" name="month">
                            <option value='0'>--Select Month--</option>
                            <option value='January'>Janaury</option>
                            <option value='June'>June</option>
                        </select> </span><span class="year">Year: </span><span><select id="selectElementId" class="form-control"
                            name="year"></select></span>
                    <span><button class="btn btn-info text-center" data-toggle="modal" data-target="#section" type="button"
                            name="showsection" style="margin-top: 10px;">Add section and advisor</button></span>
                </div>
                <div class="modal fade" id="section" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"
                                        aria-hidden="true"></span></button>
                                <h4 class="modal-title custom_align text-muted" id="Heading"><strong>Set Section And
                                        Advisor</strong></h4>
                            </div>
                            <div class="modal-body" style="max-height: 75%; overflow-y: auto;">
                                <!-- Body of section and advisor set -->
                                <div id="sectionmodalbody"></div>
                                <table class=" table sectiontable table-sm text-center">
                                    <thead>
                                        <tr class="table-success">
                                            <th>Mark active</th>
                                            <th>Section</th>
                                            <th>Set advisor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sectiondata">
                                        <!-- CALLED SECTION() TO SEND AJAX REQUEST  AT THE END OF THE FILE  -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <center> <button type="submit" class="btn btn-success" onclick="createsession()"><span
                                            class="glyphicon glyphicon-ok-sign"></span>Save</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var min = new Date().getFullYear(),
                        max = min + 2,
                        select = document.getElementById('selectElementId');
            
                    for (var i = min; i <= max; i++) {
                        var opt = document.createElement('option');
                        opt.value = i;
                        opt.innerHTML = i;
                        select.appendChild(opt);
                    }
            </script>
        </div>
        {{-- EDIT TAB FINISH --}}

        {{-- ASSIGN TEACHER TAB --}}
        <div id="subject" class="tab-pane fade" style="background: #fff">
            <!-- Body of section and advisor set -->
            <div class="table-responsive" style="overflow-y:auto; max-height: 73%;">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 4px;">
                    Section</button>
                    <div class="dropdown-menu" id="available_secs" style="max-height: 240px; overflow-y: auto" >
                    </div>
                <input type="text" class=" form-control form-control-sm" placeholder="Search" id="searchsection" style="float: right;width: 40%;margin-top: 4px;margin-bottom: 4px;" onkeyup="searchsection()">
                <table class="table assignteachertable  table-sm text-left" id="assignteacherndata">
                    <thead>
                        <tr class="table-success">
                            <th>Check</th>
                            <th>Subject</th>
                            <th>Section</th>
                            <th>Set teacher</th>
                        </tr>
                    </thead>
                    <tbody id="assignteachertbody">
                        <!-- CALLED SECTION() TO SEND AJAX REQUEST  AT THE END OF THE FILE  -->
                    </tbody>
                </table>
            </div>
            <center> <button type="button" class="btn btn-success" id="savebutton1" onclick="save_assignteacher()"><span
                        class="glyphicon glyphicon-ok-sign"></span>Save</button>
            </center>
        </div>

        {{-- UPDATE ASSIGNED TEACHER TAB --}}
        <div id="update" class="tab-pane fade" style="background: #fff">
            <!-- Body of section and advisor set -->
            <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                <input type="text" class=" form-control form-control-sm" placeholder="Search" id="searchsectionandsubject" style="float: right;width: 40%;margin-top: 4px;margin-bottom: 4px;" onkeyup="searchsectionandteacher()">
                <table class="table table-sm text-left" id="updateassignedteacher">
                    <thead>
                        <tr class="table-danger">
                            <th><input type="checkbox"></th>
                            <th>Subject</th>
                            <th>Section</th>
                            <th>Current Teacher</th>
                            <th>Update Assigned Teacher</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="updateassignedteachertbody">
                        <!-- CALLED SECTION() TO SEND AJAX REQUEST  AT THE END OF THE FILE  -->
                    </tbody>
                </table>
            </div>
            <center> <button type="button" class="btn btn-success" id="savebutton2" onclick="update_assignedteacher()"><span
                        class="glyphicon glyphicon-ok-sign"></span>Update</button>
            </center>
        </div>

        {{-- UPDATE ADVISOR TAB --}}
        <div id="update_advisor" class="tab-pane fade" style="background: #fff">
            <!-- Body of section and advisor set -->
            <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
                <input type="text" class=" form-control form-control-sm" placeholder="Search" id="searchsectionadvisor" style="float: right;width: 40%;margin-top: 4px;margin-bottom: 4px;" onkeyup="searchsectionadvisor()">
                <table class="table table-sm text-left" id="updateassignedadvisor">
                    <thead>
                        <tr class="table-info">
                            <th><input type="checkbox"></th>
                            <th>Section</th>
                            <th>Current Advisor</th>
                            <th>Advisor ID</th>
                            <th>Update Assigned Advisor</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="updateassignedadvisortbody">
                        <!-- CALLED SECTION() TO SEND AJAX REQUEST  AT THE END OF THE FILE  -->
                    </tbody>
                </table>
            </div>
            <center> <button type="button" class="btn btn-success" id="savebutton3" onclick="update_assignedadvisor()"><span
                        class="glyphicon glyphicon-ok-sign"></span>Update</button>
            </center>
        </div>
    </div>
</div>

{{-- MODAL ADD SECTION --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                <h4 class="modal-title text-muted">Add Section</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control form-control-sm" name="semester" id="value_of_semester">
                    </select>
                    <br />
                    <br />
                    <label for="usr"><strong>Add Section Name</strong></label>
                    <input type="text" class="form-control form-control-sm" id="sec_name" name="section_name" required>
                    <label for="usr"><strong>Set Advisor </strong>:</label><br>
                    <select class="form-control form-control-sm" name="advisor" id="advisor">
                    </select> <br>
                    <label for="usr"><strong>Max Student</strong></label>
                    <input type="number" class="form-control form-control-sm" id="max_stu" name="max_student" required value='60'>
                    <div id="errmsg" style="display: none; background: #facccc;color: #f04444;margin-top: 4px;padding: 4px 4px 4px 4px;"><strong>Please
                            Select Semester</strong></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_subject_button" onclick="save_section()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"
                        aria-hidden="true"></span></button> --}}
                <h4 class="modal-title custom_align text-muted" id="Headingdelete"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you
                    want to delete? <strong id="session"></strong></div>
                <input type="hidden" id="id">
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" onclick="sessiondelete()"><span class="glyphicon glyphicon-ok-sign"></span>
                    Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>
                    No</button>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- SCRIPT FOR SETTING UP YEAR --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>

<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script>


<script>
function hidemsg() {
    var n = document.getElementById('msg');
    n.style.display = 'none';
}

function hideerrmsg() {
    var n = document.getElementById('errmsg');
    n.style.display = 'none';
}

function hidemodalmsg() {
    document.getElementById('sectionmodalbody').style.display = 'none';
}

function sup(name) {
    var sup;
    if (name === '1') {
        sup = name + "<sup>st</sup>";
    } else if (name === '2') {
        sup = name + "<sup>nd</sup>";
    }
    else if (name === '3') {
        sup = name + "<sup>rd</sup>";
    }
    else
        sup = name + "<sup>th</sup>";

    return sup;
}
$('document').ready(function () {
    showoverview();

    //SET DROP DOWN VALUES
});

function setsemandtea() {
    $.ajax({
        url: 'showsemestersandteachers',
        method: 'get',
        success: function (data) {
            var dropdownsemester = document.getElementById('value_of_semester');
            var advisor = document.getElementById('advisor');
            var option_semester = '';
            var option_teacher = '';
            if (data['semesterhasdata'] === true) {
                if (data['teacherhasdata'] === true) {
                    var semesters = data['semesters'];
                    var teachers = data['teachers'];

                    for (var i = 0; i < semesters.length; i++) {
                        option_semester = option_semester + "<option value=" + semesters[i].id + ">" + sup(semesters[i].name) + " Semester" + "</option>";
                    }
                    for (var j = 0; j < teachers.length; j++) {
                        option_teacher = option_teacher + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                    }
                    dropdownsemester.innerHTML = option_semester;
                    advisor.innerHTML = option_teacher;
                } else {
                    var errors = "No teacher has been registered  Yet.";
                    document.getElementById('errmsg').innerHTML = errors;
                    document.getElementById('errmsg').style.display = 'block';
                    var hide = setTimeout(hideerrmsg, 4000);
                }
            } else {
                var errors = "No Semester has been created Yet.";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 4000);
            }

        },
        error: function (e) {
            console.log(e);
        },
    });
}

function showoverview() {
    $.ajax({
        url: 'overview',
        method: 'get',
        success: function (data) {
            if (data['sessionhasdata'] === true) {
                var sessions = data['sessions'];
                var total_student = data['totalstudent'];
                var tabledata = '';
                var status;
                var deletebutton;

                for (var i = 0; i < sessions.length; i++) {
                    var button;
                    if (sessions[i].active === '1') //DETERMINING BUTTON
                    {
                        status = 'Active';
                        button = '<button type="button" class="btn btn-danger" onclick="blockunblock(' + sessions[i].id + ',' + 0 + ')">Block</button>';
                    } else {
                        status = 'Disabled';
                        button = '<button type="button" class="btn btn-success" onclick="blockunblock(' + sessions[i].id + ',' + 1 + ')">Unblock</button>';
                    }
                    deletebutton = '<button type="button" class="btn btn-danger" onclick="deletemodal(' + sessions[i].id + ')">Delete</button>'
                    var tabledata = tabledata + '<tr><td>' + sessions[i].year + ' ' + sessions[i].month + '</td><td>' + total_student[i] + '</td><td>' + status + '</td><td>' + button + '</td><td>' + deletebutton + '</td></tr>';
                }
                document.getElementById('overviewtabtbody').innerHTML = tabledata;
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;No Session has been created Yet. </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function blockunblock(id, todo) // IF todo = 0 THEN do BLOCK THAT SESSION ELSE todo =1 do UNBLOCK
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'blockunblock/' + id + '/' + todo,
        method: 'post',
        success: function (data) {
            if (data['blockunblock'] === true) {
                showoverview();
                // var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp; </div>";
                // document.getElementById('msg').innerHTML= errors;
                // document.getElementById('msg').style.display='block';
                // var hide = setTimeout(hidemsg,4000);
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;No Session has been created Yet. </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function deletemodal(id) {
    $.ajax({
        url: 'deletemodal/' + id,
        method: 'get',
        success: function (data) {
            var sessions = data['session'];
            document.getElementById('Headingdelete').innerHTML = "Delete";
            document.getElementById('session').innerHTML = sessions[0].year + " " + sessions[0].month;
            document.getElementById('id').value = sessions[0].id;
            $('#delete').modal('show');
        },
        error: function (e) {
            console.log(e);
        }
    })
}

function sessiondelete() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#delete').modal('toggle');

    $.ajax({
        url: 'deletesession/' + document.getElementById('id').value,
        method: 'post',
        success: function (data) {
            if (data['delete'] === true) {
                showoverview();
                var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully Deleted. </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function save_section() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var semester = document.getElementById('value_of_semester').value;
    var section_name = document.getElementById('sec_name').value;
    var advisor = document.getElementById('advisor').value;
    var max_stu = document.getElementById('max_stu').value;
    if (section_name !== '' && max_stu !== '') {
        $.ajax({
            url: 'save_section',
            method: 'post',
            data: {
                semester: semester,
                section_name: section_name,
                advisor: advisor,
                max_stu:max_stu
            },
            success: function (data) {
                if (data['nosession'] === false) {
                    if (data['insert'] === true) {
                        $('#myModal').modal('toggle');
                        var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully Created Section. </div>";
                        document.getElementById('msg').innerHTML = errors;
                        document.getElementById('msg').style.display = 'block';
                        showassignedadvisor();
                        var hide = setTimeout(hidemsg, 4000);

                    } else {
                        var errors = "Data Already Exist";
                        document.getElementById('errmsg').innerHTML = errors;
                        document.getElementById('errmsg').style.display = 'block';
                        var hide = setTimeout(hideerrmsg, 4000);
                    }
                } else {
                    var errors = "Please enable session first.";
                    document.getElementById('errmsg').innerHTML = errors;
                    document.getElementById('errmsg').style.display = 'block';
                    var hide = setTimeout(hideerrmsg, 4000);
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    } else {
        var errors = "Please Fill up every section";
        document.getElementById('errmsg').innerHTML = errors;
        document.getElementById('errmsg').style.display = 'block';
        var hide = setTimeout(hideerrmsg, 2000);
    }
}

function viewsessionsection() {
    $.ajax({
        url: 'viewsessionsection',
        method: 'get',
        success: function (data) {
            if (data['sectionhasdata'] === true) {
                var tbodyofsectionmodal = document.getElementById('sectiondata');
                var msgofsectionmodalbody = document.getElementById('sectionmodalbody');
                var sections = data['sections'];
                var teacher = data['teachers'];
                var table = '';
                for (var i = 0; i < sections.length; i++) {
                    var tablerowstart = "<tr><td><input value=" + sections[i].id + " type='checkbox' name='all_section[]'></td><td>" + sections[i].name + "</td><td><select id='" + sections[i].id + "' class='form-control form-control-sm'>";
                    var tablerowend = "</select></td></tr>"
                    var option = '';
                    for (var j = 0; j < teacher.length; j++) {
                        option = option + "<option value=" + teacher[j].user_id + ">" + teacher[j].name + "</option>"
                    }
                    table = table + tablerowstart + option + tablerowend;
                }
                tbodyofsectionmodal.innerHTML = table;
            } else {
                var errors = "Could not find any previous section";
                msgofsectionmodalbody.innerHTML = errors;
                msgofsectionmodalbody.style.display = 'block';
                // var hide = setTimeout(hideerrmsg,10000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function createsession() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var month = document.getElementById('gMonth2').value;
    var year = document.getElementById('selectElementId').value;
    var msgofsectionmodalbody = document.getElementById('sectionmodalbody');
    var all_sections = document.getElementsByName('all_section[]');
    var checked_section = [];
    var count_helper = 0;
    var value_of_advisor = [];

    if (month !== '0') {
        for (var i = 0; i < all_sections.length; i++) {
            if (all_sections[i].checked) {
                checked_section[count_helper] = all_sections[i].value;
                value_of_advisor[count_helper] = document.getElementById(all_sections[i].value).value;
                count_helper++;
            }
        }
        $.ajax({
            url: 'saveselectedsection',
            method: 'post',
            data: {
                section: checked_section,
                advisor: value_of_advisor,
                month: month,
                year: year
            },
            success: function (data) {
                if (data['insert'] === true) {
                    $('#section').modal('toggle');
                    var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully Created Session. </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    var hide = setTimeout(hidemsg, 4000);
                } else {
                    var errors = '<p style="color:red;">Session Already Exist.</p>';
                    msgofsectionmodalbody.innerHTML = errors;
                    msgofsectionmodalbody.style.display = 'block';
                    var hide = setInterval(hidemodalmsg, 4000);

                }
            },
            error: function (e) {
                console.log(e);
            }
        })
    } else {
        var errors = '<p style="color:red;">Please select Month</p>';
        msgofsectionmodalbody.innerHTML = errors;
        msgofsectionmodalbody.style.display = 'block';
        var hide = setInterval(hidemodalmsg, 4000);
    }
}

var sections = []; //THIS VARIABLE CREATED FOR TRACKING SECTION ID WHEN USER ASSIGNING TEACHER
function assignteacher() {
    $.ajax({
        url: '/assignteacher',
        method: 'get',

        success: function (data) {
            
            var session = data['session'];
            if (session === true) {
                var subjects = data['subjects'];
                var teachers = data['teachers'];
                var assignteachertbody = document.getElementById('assignteachertbody');
                var option = '';
                var table = '';
                var sections_name='<a class="dropdown-item" href="#" onclick="assignteacher()">SHOW ALL</a>   <div class="dropdown-divider"></div>';
                for(var i=0;i<data['sections'].length;i++)
                {
                    sections_name = sections_name + '<a class="dropdown-item" href="#" onclick="show_selected_assign_teacher('+data['sections'][i].id+')">'+data['sections'][i].name+'</a>';
                }
                 document.getElementById('available_secs').innerHTML = sections_name;
                for (var i = 0; i < subjects.length; i++) {
                    sections[i] = subjects[i].secid;
                    var tablerowstart = "<tr><td><input type='checkbox' value=" + subjects[i].subid + " name='subjects_check[]'></td><td>" + subjects[i].subname + "</td><td>" + subjects[i].secname + "</td><td><select name='teacher[]' class='form-control form-control-sm'>";
                    var tablerowend = "</select></td></tr>";
                    for (var j = 0; j < teachers.length; j++) {
                        option = option + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>"
                    }
                    table = table + tablerowstart + option + tablerowend;
                }
                assignteachertbody.innerHTML = table;
                document.getElementById('assignteacherndata').style.display = '';
                document.getElementById('savebutton1').style.display = '';
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Have you forgotten to enable session in OVERVIEW TAB? </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                document.getElementById('msg').style.transition = '3s';
                document.getElementById('assignteacherndata').style.display = 'none';
                document.getElementById('savebutton1').style.display = 'none';
                var hide = setInterval(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function save_assignteacher() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var all_subjects = document.getElementsByName('subjects_check[]');
    var all_teacher = document.getElementsByName('teacher[]');
    var checked_sub = [];
    var teacher = [];
    var section_id = [];
    var count_helper = 0;
    for (var i = 0; i < all_subjects.length; i++) {
        if (all_subjects[i].checked) {
            checked_sub[count_helper] = all_subjects[i].value;
            teacher[count_helper] = all_teacher[i].value;
            section_id[count_helper] = sections[i];
            count_helper++;
        }
    }

    $.ajax({
        url: 'saveassignedteacher',
        method: 'post',
        data: {
            subjects: checked_sub,
            teacher: teacher,
            section: section_id
        },
        success: function (data) {
            if (data['noinput'] === false) {
                if (data['insert'] === true) {
                    assignteacher();
                    var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully assigned. </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transition = '3s';
                    var hide = setInterval(hidemsg, 4000);
                }
                var failed = data['failed'];
                for (var i = 0; i < failed.length; i++) {
                    var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;To insert" + failed[i] + ". </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transition = '3s';
                }
                var hide = setInterval(hidemsg, 4000);
                //assignteacher(); 
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Mark At least one. </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                document.getElementById('msg').style.transition = '3s';
                var hide = setInterval(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function showassignedteacher() {
    $.ajax({
        url: '/showassignedteacher',
        method: 'get',
        success: function (data) {
            var no_session = data['nosession'];
            if (no_session === false) {
                if (data['failed'] === false) {
                    var tablerow_start = '';
                    var tblcontent = ' ';
                    var tablerow_ends = ' ';
                    var table_data = ' ';
                    var all_data = data['data'];
                    var teachers = data['teachers'];
                    var tbodyofupdateassignedteacher = document.getElementById('updateassignedteachertbody');
                    for (var i = 0; i < all_data.length; i++) {
                        tablerow_start = "<tr><td><input type='checkbox' name='updatesubjectsteacher[]' value=" + all_data[i].id + "></td><td>" + all_data[i].subname + "</td><td>" + all_data[i].secname + "</td><td>" + all_data[i].teachername + "</td><td><select class='" + all_data[i].id + " form-control form-control-sm'>";
                        tablerow_ends = "</select></td><td><button class='btn btn-danger' onclick='deleteassignedteacher(" + all_data[i].id + ")'>Delete</button></td></tr>";
                        for (var j = 0; j < teachers.length; j++) {
                            tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                        }
                        table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                    }
                    tbodyofupdateassignedteacher.innerHTML = table_data;
                    document.getElementById('updateassignedteacher').style.display = '';
                    document.getElementById('savebutton2').style.display = '';

                } else {
                    //data['failed] === true
                    var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Please Assign Teacher First !!! </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transitionDuration = 'all 3s';
                    document.getElementById('updateassignedteacher').style.display = 'none';
                    document.getElementById('savebutton2').style.display = 'none';
                    var hide = setInterval(hidemsg, 4000);
                }
            } else {
                //data['nosession] === true

                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Have you forgotten to enable session in OVERVIEW TAB? </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                document.getElementById('msg').style.transitionDuration = 'all 3s';
                document.getElementById('updateassignedteacher').style.display = 'none';
                document.getElementById('savebutton2').style.display = 'none';
                var hide = setInterval(hidemsg, 4000);
            }

        },
        error: function (e) {
            console.log(e);
        },
    });
}

function deleteassignedteacher(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'deleteassignedteacher/' + id,
        method: 'post',
        success: function (data) {
            if (data['delete'] === true) {
                // document.getElementById('updateassignedteachertbody').removeChild('tr');
                showassignedteacher();
            }
        },
        error: function (e) {
            console.log(e);
        }
    })
}

function update_assignedteacher() {
    var inp = document.getElementsByName('updatesubjectsteacher[]');
    var checked = [];
    var teacher_value = [];
    var count_check = 0;
    for (var i = 0; i < inp.length; i++) {
        if (inp[i].checked) {
            checked[count_check] = inp[i].value;
            count_check++;
        }
    }
    if (checked.length > 0) {
        for (var i = 0; i < checked.length; i++) {
            teacher_value[i] = $('.' + checked[i]).val();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updateselectedteacher',
            method: 'post',
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
            data: {
                id: checked,
                teacher: teacher_value
            },
            success: function (data) {
                if (data['update'] === true) {
                    showassignedteacher();
                    var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully Updated. </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transitionDuration = 'all 3s';
                    var hide = setInterval(hidemsg, 4000);
                }
            },
            error: function (e) {
                console.log(e);
            }

        });
    } else {
        var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Please select at least one subject. </div>";
        document.getElementById('msg').innerHTML = errors;
        document.getElementById('msg').style.display = 'block';
        document.getElementById('msg').style.transitionDuration = 'all 3s';
        var hide = setInterval(hidemsg, 4000);
    }

}

function showassignedadvisor() {
    $.ajax({
        url: 'updatedadvisor',
        method: 'get',
        success: function (data) {
            if (data['nosession'] === false) {
                var all_data = data['data'];
                var teachers = data['teachers']
                var table_data = ' ';
                if (data['nodata'] === false) {
                    for (var i = 0; i < data['data'].length; i++) {
                        tablerow_start = "<tr><td><input type='checkbox' name='updatesectionadvisor[]' value=" + all_data[i].id + "></td><td>" + all_data[i].secname + "</td><td>" + all_data[i].advisorname + "</td><td>"+all_data[i].user_id+"</td><td><select class='" + all_data[i].id + " form-control form-control-sm'>";
                        tablerow_ends = "</select></td><td><button class='btn btn-danger' onclick='deleteassignedadvisor(" + all_data[i].id + ")'>Disable</button></td></tr>";
                        var tblcontent = ' ';
                        for (var j = 0; j < teachers.length; j++) {
                            tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                        }
                        table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                    }
                    var unmark = data['unmarked'];
                    for (var i = 0; i < unmark.length; i++) {
                        tablerow_start = "<tr><td><input type='checkbox' name='updatesectionadvisor[]' value=" + unmark[i].id + "></td><td>" + unmark[i].secname + "</td><td>----------</td><td>----------</td><td><select id='" + unmark[i].id + "' class='form-control'>";
                        tablerow_ends = "</select></td><td><button class='btn btn-success' onclick='enablesectiondadvisor(" + unmark[i].id + ")'>Enable</button></td></tr>";
                        for (var j = 0; j < teachers.length; j++) {
                            tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                        }
                        table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                    }
                    // console.log(table_data);
                    document.getElementById('updateassignedadvisortbody').innerHTML = table_data;
                    document.getElementById('updateassignedadvisor').style.display = '';
                    document.getElementById('savebutton3').style.display = '';
                } else {
                    document.getElementById('updateassignedadvisortbody').innerHTML = '';
                    var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;You Have not set any advisor</div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transitionDuration = 'all 3s';
                    var hide = setInterval(hidemsg, 4000);
                }
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Have you forgotten to enable session in OVERVIEW TAB? </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                document.getElementById('msg').style.transitionDuration = 'all 3s';
                document.getElementById('updateassignedadvisor').style.display = 'none';
                document.getElementById('savebutton3').style.display = 'none';
                var hide = setInterval(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function deleteassignedadvisor(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'deleteassignedadvisor/' + id,
        method: 'post',
        success: function (data) {
            if (data['delete'] === true) {
                // document.getElementById('updateassignedteachertbody').removeChild('tr');
                showassignedadvisor();
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function enablesectiondadvisor(id) {
    var teacher = document.getElementById(id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'enablesectiondadvisor/' + id,
        method: 'post',
        data: {
            teacher: teacher
        },
        success: function (data) {
            if (data['insert'] === true) {
                showassignedadvisor();
            } else {
                var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Have you forgotten to enable session in OVERVIEW TAB? </div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                document.getElementById('msg').style.transitionDuration = 'all 3s';
                showassignedadvisor();
                var hide = setInterval(hidemsg, 4000);
            }
        },
        error: function (e) {
            console.log(e);
        },
    })
}

function update_assignedadvisor() {
    var inp = document.getElementsByName('updatesectionadvisor[]');
    var checked = [];
    var advisor_value = [];
    var count_check = 0;
    for (var i = 0; i < inp.length; i++) {
        if (inp[i].checked) {
            checked[count_check] = inp[i].value;
            count_check++;
        }
    }
    if (checked.length > 0) {
        for (var i = 0; i < checked.length; i++) {
            advisor_value[i] = $('.' + checked[i]).val();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updateselectedadvisor',
            method: 'post',
            // beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
            data: {
                id: checked,
                advisor: advisor_value
            },
            success: function (data) {
                if (data['update'] === true) {
                    showassignedadvisor();
                    var errors = "<div class='alert alert-success'><strong>Success!</strong>&nbsp;Successfully Updated. </div>";
                    document.getElementById('msg').innerHTML = errors;
                    document.getElementById('msg').style.display = 'block';
                    document.getElementById('msg').style.transitionDuration = 'all 3s';
                    var hide = setInterval(hidemsg, 4000);
                }
            },
            error: function (e) {
                console.log(e);
            }

        });
    } else {
        var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;Please select at least one subject. </div>";
        document.getElementById('msg').innerHTML = errors;
        document.getElementById('msg').style.display = 'block';
        document.getElementById('msg').style.transitionDuration = 'all 3s';
        var hide = setInterval(hidemsg, 4000);
    }
}

function searchsection()
{
    searched_text = document.getElementById("searchsection").value;
    // console.log(searched_text);

    if(searched_text !== '')
    {
        $.ajax({
            url:'searchsection/'+searched_text,
            method:'get',
            success:function(data)
            {
                
                if(data['subjects'].length > 0)
                {
                    var subjects = data['subjects'];
                    var teachers = data['teachers'];
                    var assignteachertbody = document.getElementById('assignteachertbody');
                    var option = '';
                    var table = '';
                    for (var i = 0; i < subjects.length; i++) {
                        sections[i] = subjects[i].secid;
                        var tablerowstart = "<tr><td><input type='checkbox' value=" + subjects[i].subid + " name='subjects_check[]'></td><td>" + subjects[i].subname + "</td><td>" + subjects[i].secname + "</td><td><select name='teacher[]' class='form-control form-control-sm'>";
                        var tablerowend = "</select></td></tr>";
                        for (var j = 0; j < teachers.length; j++) {
                            option = option + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>"
                        }
                        table = table + tablerowstart + option + tablerowend;
                    }
                    assignteachertbody.innerHTML = table;
                    document.getElementById('assignteacherndata').style.display = '';
                    document.getElementById('savebutton1').style.display = '';
                }
                else
                {
                    document.getElementById('assignteacherndata').style.display = 'none';
                    document.getElementById('savebutton1').style.display = 'none';
                }
            },
            error:function(e)
            {
                console.log(e);
            },
        });
    }
    else
    {
        assignteacher();
        document.getElementById('assignteacherndata').style.display = '';
    }

}
function searchsectionandteacher()
{
    var search_text = document.getElementById('searchsectionandsubject').value;
    if(search_text !== '')
    {
        $.ajax({
            url:'searchsectionandteacher/'+search_text,
            method:'get',
            success:function(data)
            {
            if(data['data'].length>0)
            {
                var tablerow_start = '';
                    var tblcontent = ' ';
                    var tablerow_ends = ' ';
                    var table_data = ' ';
                    var all_data = data['data'];
                    var teachers = data['teachers'];
                    var tbodyofupdateassignedteacher = document.getElementById('updateassignedteachertbody');
                    for (var i = 0; i < all_data.length; i++) {
                        tablerow_start = "<tr><td><input type='checkbox' name='updatesubjectsteacher[]' value=" + all_data[i].id + "></td><td>" + all_data[i].subname + "</td><td>" + all_data[i].secname + "</td><td>" + all_data[i].teachername + "</td><td><select class='" + all_data[i].id + " form-control form-control-sm'>";
                        tablerow_ends = "</select></td><td><button class='btn btn-danger' onclick='deleteassignedteacher(" + all_data[i].id + ")'>Delete</button></td></tr>";
                        for (var j = 0; j < teachers.length; j++) {
                            tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                        }
                        table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                    }
                    tbodyofupdateassignedteacher.innerHTML = table_data;
                    document.getElementById('updateassignedteacher').style.display = '';
                    document.getElementById('savebutton2').style.display = '';
            }
            else
            {
                document.getElementById('updateassignedteacher').style.display = 'none';
                document.getElementById('savebutton2').style.display = 'none';
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
        showassignedteacher();
    }
}
function searchsectionadvisor()
{
    var search_text = document.getElementById('searchsectionadvisor').value;
    if(search_text !== '')
    {
        $.ajax({
            url:'searchsectionadvisor/'+search_text,
            method:'get',
            success:function(data)
            {
                var all_data = data['data'];
                var teachers = data['teachers']
                var table_data = ' ';
                if(data['data'].length>0){
                    for (var i = 0; i < data['data'].length; i++) {
                        if(data['data'][i].session_id !== null)
                        {
                            tablerow_start = "<tr><td><input type='checkbox' name='updatesectionadvisor[]' value=" + all_data[i].id + "></td><td>" + all_data[i].secname + "</td><td>" + all_data[i].advisorname + "</td><td>"+all_data[i].user_id+"</td><td><select class='" + all_data[i].id + " form-control form-control-sm'>";
                            tablerow_ends = "</select></td><td><button class='btn btn-danger' onclick='deleteassignedadvisor(" + all_data[i].id + ")'>Disable</button></td></tr>";
                            var tblcontent = ' ';
                            for (var j = 0; j < teachers.length; j++) {
                                tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                            }
                            table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                        }
                        else
                        {
                            tablerow_start = "<tr><td><input type='checkbox' name='updatesectionadvisor[]' value=" + all_data[i].id + "></td><td>" + all_data[i].secname + "</td><td>----------</td><td>----------</td><td><select id='" + all_data[i].id + "' class='form-control'>";
                            tablerow_ends = "</select></td><td><button class='btn btn-success' onclick='enablesectiondadvisor(" + all_data[i].id + ")'>Enable</button></td></tr>";
                            for (var j = 0; j < teachers.length; j++) {
                                tblcontent = tblcontent + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>";
                            }
                            table_data = ' ' + table_data + tablerow_start + tblcontent + tablerow_ends + ' ';
                        }
                    document.getElementById('updateassignedadvisortbody').innerHTML = table_data;
                    document.getElementById('updateassignedadvisor').style.display = '';
                    document.getElementById('savebutton3').style.display = '';
                    }
                }
                else
                {
                    document.getElementById('updateassignedadvisor').style.display = 'none';
                    document.getElementById('savebutton3').style.display = 'none';
                }
            },
            error:function(e)
            {
                console.log(e);
            },
        });
    }
    else
    {
        showassignedadvisor();
    }
}

function show_selected_assign_teacher(id)
{
    $.ajax({
        url:'get_selected_section/'+id,
        method:'get',
        success:function(data)
        {
            if(data['subjects'].length > 0)
                {
                    var subjects = data['subjects'];
                    var teachers = data['teachers'];
                    var assignteachertbody = document.getElementById('assignteachertbody');
                    var option = '';
                    var table = '';
                    for (var i = 0; i < subjects.length; i++) {
                        sections[i] = subjects[i].secid;
                        var tablerowstart = "<tr><td><input type='checkbox' value=" + subjects[i].subid + " name='subjects_check[]'></td><td>" + subjects[i].subname + "</td><td>" + subjects[i].secname + "</td><td><select name='teacher[]' class='form-control form-control-sm'>";
                        var tablerowend = "</select></td></tr>";
                        for (var j = 0; j < teachers.length; j++) {
                            option = option + "<option value=" + teachers[j].user_id + ">" + teachers[j].name + "</option>"
                        }
                        table = table + tablerowstart + option + tablerowend;
                    }
                    assignteachertbody.innerHTML = table;
                    document.getElementById('assignteacherndata').style.display = '';
                    document.getElementById('savebutton1').style.display = '';
                }
                else
                {
                    document.getElementById('assignteacherndata').style.display = 'none';
                    document.getElementById('savebutton1').style.display = 'none';
                }
        },
        error:function(e)
        {
            console.log(e);
        }
    });
}
</script>