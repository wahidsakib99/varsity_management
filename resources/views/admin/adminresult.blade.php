@extends('mainlayout')
@section('title')
Admin | Result
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div id="msg"></div> <!-- DIV FOR SHOWING MESSAGES -->

<div class="container">
    <h4 class="float-left" id="head">
        <!-- SEMESTER WILL GO HERE -->
    </h4>
    <br>
    <hr>
    <ul class="nav nav-tabs">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Sections<span class="caret"></span></a>
            <ul class="dropdown-menu" style="max-height: 150px;overflow-y: auto;" id="sectionslist">
                {{-- DROPDOWN LIST GOES HERE --}}
            </ul>
        </li>
    </ul>
    <div class="table-responsive" style="overflow-y:auto; max-height: 73%">
        <table class="table table-sm text-center table-hover" id="sectionstudentinfo">
            <thead>
                <tr class="table-info">
                    <th>Name</th>
                    <th>ID</th>
                    <th>Average CGPA</th>
                </tr>
            </thead>
            <tbody id="sectionstudentinfotbody">
                <!-- CALLED SECTION() TO SEND AJAX REQUEST  AT THE END OF THE FILE  -->
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL FOR RESULT --}}
<div id="stuinformationmodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header" style="height: 50px;">
                <h4 class="modal-title" id="myLargeModalLabel">Result</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-x: hidden;overflow-y: hidden">
                <!-- MODAL BODY -->
                <div class="container">
                    <div class="mainpart" style="height: 120px;">
                        <div class="imageandid" style="display: flex;float: left">
                            <img src="https://www.w3schools.com/howto/img_avatar.png" height="100px" width="100px;" id="proimg">
                            <div id="info" class="idandsec" style="margin-top: -2px;margin-left: 10px;">
                                <!-- NAME ID SECTION CGPA -->
                            </div>
                        </div>
                        {{-- <div class="info" style="float: right;margin-top: 10px;m">
                            <label> Average CGPA: 2.8</label>
                        </div> --}}
                    </div>
                    <br>
                    <!--TABS -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#rslt">Result</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rtkrcrse" onclick="showretake()">Retake/Recourse</a></li>
                    </ul>
                    <!--TABS END -->


                    <div class="tab-content">

                        <!-- RESULT BODY -->

                        <div id="rslt" class="tab-pane fade show active rslt" style="max-height:55%;overflow-y: auto; background:white;margin-top:5px;">
                            <div class="frst">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#frsttable"
                                        onclick="showresultstudent(1)"><b>1<sup>st</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="frsttable">
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="firstresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="firstsemesterresult">
                                            <!-- WILL BE ADDED DYNIMACALLY -->
                                        </tbody>
                                    </table>
                                    <div id="1" style="display: none"></div>
                                </div>
                            </div>
                            <div class="scnd">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#scndtable"
                                        onclick="showresultstudent(2)"><b>2<sup>nd</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="scndtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="scndresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="scndsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="2" style="display: none"></div>
                                </div>
                            </div>

                            <div class="thrd">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#thrdtable"
                                        onclick="showresultstudent(3)"><b>3<sup>rd</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="thrdtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="thrdresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="thirdsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="3" style="display: none"></div>
                                </div>
                            </div>
                            <div class="frth">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#frthtable"
                                        onclick="showresultstudent(4)"><b>4<sup>th</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="frthtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="frthresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="frthsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="4" style="display: none"></div>
                                </div>
                            </div>
                            <div class="ffth">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#ffthtable"
                                        onclick="showresultstudent(5)"><b>5<sup>th</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="ffthtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="ffthresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ffthsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="5" style="display: none"></div>
                                </div>
                            </div>

                            <div class="sxth">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#sxthtable"
                                        onclick="showresultstudent(6)"><b>6<sup>th</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="sxthtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="sxthresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sxthsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="6" style="display: none"></div>
                                </div>
                            </div>

                            <div class="svnth">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#svnthtable"
                                        onclick="showresultstudent(7)"><b>7<sup>th</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="svnthtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="svnthresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="svnthsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="7" style="display: none"></div>
                                </div>
                            </div>

                            <div class="eghth">
                                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 100%;">
                                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                                        type="button" class="frstbtn" data-toggle="collapse" data-target="#eghthtable"
                                        onclick="showresultstudent(8)"><b>8<sup>th</sup>&nbsp;Semester</b></button>
                                </div>
                                <div class="collapse" id="eghthtable">
                                    <!-- TABLE SEMESTER DATA -->
                                    <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                        id="eghthresulttable">
                                        <thead>
                                            <tr class="resulttr">
                                                <th>Subject</th>
                                                <th>Attendance</th>
                                                <th>Class Test</th>
                                                <th>Report/Assignment</th>
                                                <th>Mid Term</th>
                                                <th>Final</th>
                                                <th>Grade</th>
                                                <th>CGPA</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eghthsemesterrslt">
                                        </tbody>
                                    </table>
                                    <div id="8" style="display: none"></div>
                                </div>
                            </div>
                        </div>
                        <!-- RESULT BODY ENDS -->

                        <div id="rtkrcrse" class="tab-pane fade rtkrcrse" style="background:white">
                            <table class="table table-sm" style="width:60%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                                id="rtktable">
                                <thead>
                                    <tr class="resulttr">
                                        <th>Subject</th>
                                        <th>Semester</th>
                                        <th>Attendance</th>
                                        <th>Class Test</th>
                                        <th>Report/Assignment</th>
                                        <th>Mid Term</th>
                                        <th>Final</th>
                                        <th>Grade</th>
                                        <th>CGPA</th>
                                    </tr>
                                </thead>
                                <tbody id="rtktbody">

                                </tbody>
                                <div id="rtkmsg"></div>
                        </div>
                    </div>
                </div>

                <!-- MODAL BODY ENDS-->
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
    function hidemsg() {
        document.getElementById('msg').style.display = 'none';
    }

    function showerrors(msg, divid, methodname, time) {
        var errors = "<div class='alert alert-danger'><strong>Failed!</strong>&nbsp;" + msg + " </div>";
        document.getElementById(divid).innerHTML = errors;
        document.getElementById(divid).style.display = 'block';
        var hide = setTimeout(methodname, time);
    }

    $('document').ready(function () {
        $.ajax({
            url: 'adminsectionlist',
            method: 'get',
            success: function (data) {  
                if (data['nosession'] === false) {
                    if (data['success'] === true) {
                        var sectionlist = data['section'];
                        var list = '';
                        for (var i = 0; i < sectionlist.length; i++) {
                            list = list + "<li onclick='showlist(" + sectionlist[i].id + ")' style='cursor:pointer'><a class='dropdown-item'>" +'&nbsp;'+sectionlist[i].name + "</a></li>"
                        }
                        document.getElementById('sectionslist').innerHTML = list;
                        showlist(sectionlist[0].id);
                    } else {
                        showerrors('No section has been created for this session yet', 'msg', hidemsg, 4000);
                    }
                } else {
                    showerrors('Enable session First', 'msg', hidemsg, 4000);
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    });

    function showlist(id) {

        $.ajax({
            url: 'showstudents/' + id,
            method: 'get',
            success: function (data) {
                document.getElementById('head').innerHTML = "Section: " + data['section_name']; //SECTION HEADING
                if (data['nostudent'] === false) {
                    var datum = data['data'];
                    var table = '';
                    var tabledata = '';
                    for (var i = 0; i < datum.length; i++) {
                        tabledata = tabledata + "<tr onclick='showstudentinfo(" + datum[i].student_id + ",\"" + datum[i].name + "\",\"" + data['section_name'] + "\"," + datum[i].averagecgpa + ")' style='cursor:pointer;'><td>" + datum[i].name + "</td><td>" + datum[i].student_id + "</td><td>" + datum[i].averagecgpa + "</td></tr>";
                    }
                    document.getElementById('sectionstudentinfotbody').innerHTML = tabledata;
                    document.getElementById('sectionstudentinfo').style.display = '';
                } else {
                    showerrors('No student has enrolled for this session yet', 'msg', hidemsg, 4000);
                    document.getElementById('sectionstudentinfo').style.display = 'none';
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    }
    var user__id;
    var datatable = ['frsttable', 'scndtable', 'thrdtable', 'frthtable', 'ffthtable', 'sxthtable', 'svnthtable', 'eghthtable'];
    var tbody_of_result_table = ['firstsemesterresult', 'scndsemesterrslt', 'thirdsemesterrslt', 'frthsemesterrslt', 'ffthsemesterrslt', 'sxthsemesterrslt', 'svnthsemesterrslt', 'eghthsemesterrslt'];
    var table_of_result = ['firstresulttable', 'scndresulttable', 'thrdresulttable', 'frthresulttable', 'ffthresulttable', 'sxthresulttable', 'svnthresulttable', 'eghthresulttable'];

    function showstudentinfo(id, name, section, cgpa) {
        user__id = id;
        var info = "<label>" + name + "</label><br><label>ID: " + id + "</label><br><label>Section: " + section + "</label><br><label>Average CGPA: " + cgpa + "</label>";
        document.getElementById('info').innerHTML = info;


        for (var i = 0; i < datatable.length; i++) {
            $('#' + datatable[i]).collapse('hide');
        }
        $('#stuinformationmodal').modal('show');
    }

    function showresultstudent(semester) {
        if ($('#' + datatable[semester - 1]).is(":hidden")) {
            $.ajax({
                url: 'getstudentresult/' + user__id + '/' + semester,
                method: 'get',
                success: function (data) {
                    if (data['semester'] === true) {
                        if (data['nodata'] === false) {
                            var datas = data['data'];
                            var avg = data['avg'];
                            var tablrowstart = '';
                            var tablrowend = "<tr><td colspan='6'></td><td><label>Average</label></td><td><label>" + avg + "</label></td></tr>";
                            for (var i = 0; i < datas.length; i++) {
                                tablrowstart = tablrowstart + "<tr><td>" + datas[i].name + "</td><td>" + datas[i].attendance + "</td><td>" + datas[i].ct + "</td><td>" + datas[i].rora + "</td><td>" + datas[i].mid + "</td><td>" + datas[i].final + "</td><td>" + datas[i].grade + "</td><td>" + datas[i].cgpa + "</td></tr>";
                            }

                            document.getElementById(tbody_of_result_table[semester - 1]).innerHTML = tablrowstart + tablrowend;
                            document.getElementById(table_of_result[semester - 1]).style.display = '';
                            document.getElementById(semester).style.display = 'none';
                        } else {
                            var text = "No Result"
                            document.getElementById(table_of_result[semester - 1]).style.display = 'none';
                            document.getElementById(semester).innerHTML = text;
                            document.getElementById(semester).style.display = 'block';
                        }
                    } else {
                        //SEMESTER NOT FOUND
                        document.getElementById(table_of_result[semester - 1]).style.display = 'none';
                        document.getElementById(semester).style.display = 'none';
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    }

    function sup(name) {
        if (name === 1) {
            name = name + "<sup>st</sup>";
        } else if (name === 2) {
            name = name + "<sup>nd</sup>";
        } else if (name === 3) {
            name = name + "<sup>rd</sup>";
        } else {
            name = name + "<sup>th</sup>";
        }
        return name;
    }

    function showretake() {
        $.ajax({
            url: 'showretake/' + user__id,
            method: 'get',
            success: function (data) {
                if (data['nodata'] === false) {
                    tablerow = '';
                    var data = data['data'];
                    for (var i = 0; i < data.length; i++) {
                        tablerow = tablerow + "<tr><td>" + data[i].subname + "</td><td>" + sup(data[i].semname) + "</td><td>" + datas[i].attendance + "</td><td>" + datas[i].ct + "</td><td>" + datas[i].rora + "</td><td>" + datas[i].mid + "</td><td>" + datas[i].final + "</td><td>" + datas[i].grade + "</td><td>" + datas[i].cgpa + "</td></tr>";
                    }
                    document.getElementById('rtktable').innerHTML = tablerow;
                    document.getElementById('rtktable').style.display = '';
                    document.getElementById('rtkmsg').style.display = 'none';
                } else {
                    document.getElementById('rtktable').style.display = 'none';
                    document.getElementById('rtkmsg').innerHTML = "No Result";
                    document.getElementById('rtkmsg').style.display = 'block';
                }
            },
            error: function (e) {
                console.log(e);
            },
        });
    }
   </script>
   