@extends('mainlayout')
@section('title')
Student | Result
@endsection
@section('rightcontent')
<div class="container">
    <div class="mainpart" style="height: 120px;">
        <div class="imageandid" style="display: flex;float: left" >
            <img  height="100px" width="100px;" id="proimg">
            <div id="info" class="idandsec" style="margin-top: 5px;margin-left: 10px;">
                <!-- NAME ID SECTION CGPA -->
            </div>
        </div>
        {{-- <div class="info" style="float: right;margin-top: 10px;m">
            <label> Average CGPA: 2.8</label>
        </div> --}}
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#rslt">Result</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rtkrcrse" onclick="showretake()">Retake/Recourse</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#incomplete" onclick="incomplete()">Incomplete</a></li>
    </ul>
    <div class="tab-content">
        <div id="rslt" class="tab-pane fade show active rslt" style="max-height:55%;overflow-y: auto; background:white;margin-top:5px;">
            <div class="frst">
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#frsttable" onclick="showresultstudent(1)"><b>1<sup>st</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="frsttable">
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="firstresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#scndtable" onclick="showresultstudent(2)"><b>2<sup>nd</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="scndtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="scndresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#thrdtable" onclick="showresultstudent(3)"><b>3<sup>rd</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="thrdtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="thrdresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#frthtable" onclick="showresultstudent(4)"><b>4<sup>th</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="frthtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="frthresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#ffthtable" onclick="showresultstudent(5)"><b>5<sup>th</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="ffthtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="ffthresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#sxthtable" onclick="showresultstudent(6)"><b>6<sup>th</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="sxthtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="sxthresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#svnthtable" onclick="showresultstudent(7)"><b>7<sup>th</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="svnthtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="svnthresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
                <div class="bdy" style="border: none;border-bottom: 1px solid grey;width: 90%;">
                    <button style="background: transparent;border:1px solid grey;border-bottom:none;border-radius:3px; outline:none;height:40px;margin-top: 15px;"
                        type="button" class="frstbtn" data-toggle="collapse" data-target="#eghthtable" onclick="showresultstudent(8)"><b>8<sup>th</sup>&nbsp;Semester</b></button>
                </div>
                <div class="collapse" id="eghthtable">
                    <!-- TABLE SEMESTER DATA -->
                    <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                        id="eghthresulttable">
                        <thead>
                            <tr class="resulttr table-info">
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
        {{-- RETAKE RECOURSE --}}
        <div id="rtkrcrse" class="tab-pane fade rtkrcrse" style="background:white">
            <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                id="rtktable">
                <thead>
                    <tr class="resulttr table-info">
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
            </table>
            <div id="rtkmsg"></div>
        </div>
        {{-- INCOMPLETE --}}
        <div id="incomplete" class="tab-pane fade incomplete" style="background:white">
            <table class="table table-sm text-center" style="width:85%; border: 1px solid grey;margin-top: 5px;margin-left: 45px;"
                id="incompletetable">
                <thead>
                    <tr class="resulttr table-info">
                        <th>Subject</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody id="incomtbody">

                </tbody>
            </table>
            <div id="incommsg"></div>
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
        var datatable = ['frsttable', 'scndtable', 'thrdtable', 'frthtable', 'ffthtable', 'sxthtable', 'svnthtable', 'eghthtable'];
        var tbody_of_result_table = ['firstsemesterresult', 'scndsemesterrslt', 'thirdsemesterrslt', 'frthsemesterrslt', 'ffthsemesterrslt', 'sxthsemesterrslt', 'svnthsemesterrslt', 'eghthsemesterrslt'];
        var table_of_result = ['firstresulttable', 'scndresulttable', 'thrdresulttable', 'frthresulttable', 'ffthresulttable', 'sxthresulttable', 'svnthresulttable', 'eghthresulttable'];

        function hidemsg() {
            document.getElementById('msg').style.display = 'none';
        }
        $('document').ready(function () {
            $.ajax({
                url: 'studentinfo',
                method: 'get',
                success: function (data) {
                    var datas = data['data'];
                   // var section = data['section'];
                    if(data['section'] !== null)
                    {}
                    else
                        data['section'] = 'Not Enrolled';
                    
                    var info = "<label>" + datas.name + "</label><br><label>ID: " + datas.student_id + "</label><br><label>Section: " + data['section'].name + "</label><br><label>Average CGPA: " + datas.averagecgpa + "</label>";
                    document.getElementById('info').innerHTML = info;
                    document.getElementById('proimg').src = "http://127.0.0.1:8000/images/"+datas['img'];
                },
                error: function (e) {
                    console.log(e);
                },
            });
        });

        function showresultstudent(semester) {
            if ($('#' + datatable[semester - 1]).is(":hidden")) {
                $.ajax({
                    url: 'getresult/' + semester,
                    method: 'get',
                    success: function (data) {
                        if (data['semester'] === true) {
                            if (data['nodata'] === false) {
                                var datas = data['data'];
                                var avg = data['avg'];
                                var tablrowstart = '';
                                var tablrowend = "<tr><td colspan='6'></td><td><label>Average</label></td><td><label>" + avg + "</label></td></tr>";
                                for (var i = 0; i < datas.length; i++) {
                                    tablrowstart = tablrowstart + "<tr><td>" + datas[i].name + "</td><td>" + datas[i].attendance + " ("+datas[i].out_at+")</td><td>" + datas[i].ct + " ("+datas[i].out_ct+")</td><td>" + datas[i].rora + " ("+datas[i].out_rora+")</td><td>" + datas[i].mid + " ("+datas[i].out_mid+")</td><td>" + datas[i].final + " ("+datas[i].out_final+")</td><td>" + datas[i].grade + "</td><td>" + datas[i].cgpa + "</td></tr>";
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
            name = String(name);
            if (name === '1') {
                name = name + "<sup>st</sup>";
            } else if (name === '2') {
                name = name + "<sup>nd</sup>";
            } else if (name === '3') {
                name = name + "<sup>rd</sup>";
            } else {
                name = name + "<sup>th</sup>";
            }
            return name;
        }

        function showretake() {
            $.ajax({
                url: 'studentretake',
                method: 'get',
                success: function (data) {
                    if (data['nodata'] === false) {
                        tablerow = '';
                        var datas = data['data'];
                        for (var i = 0; i < datas.length; i++) {
                            tablerow = tablerow + "<tr><td>" + datas[i].subname + "</td><td>" + sup(datas[i].semname) + "</td><td>" + datas[i].attendance + "</td><td>" + datas[i].ct + "</td><td>" + datas[i].rora + "</td><td>" + datas[i].mid + "</td><td>" + datas[i].final + "</td><td>" + datas[i].grade + "</td><td>" + datas[i].cgpa + "</td></tr>";
                        }
                        document.getElementById('rtktbody').innerHTML = tablerow;
                        document.getElementById('rtktable').style.display = '';
                        document.getElementById('rtkmsg').style.display = 'none';
                    } else {
                        document.getElementById('rtktable').style.display = 'none';
                        document.getElementById('rtkmsg').innerHTML = "You have <strong>0</strong> retake";
                        document.getElementById('rtkmsg').style.display = 'block';
                    }
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function incomplete() {
            $.ajax({
                url: 'showincomplete',
                method: 'get',
                success: function (data) {
                    if (data['enroll'] === true) {
                        if (data['nodata'] === false) {
                            var subs = data['subject'];
                            var sems = data['sem'];
                            var tablerow = '';
                            for (var i = 0; i < subs.length; i++) {
                                tablerow = tablerow + "<tr><td>" + subs[i] + "</td><td>" + sup(sems[i]) + "</td></tr>";
                            }
                            document.getElementById('incomtbody').innerHTML = tablerow;
                            document.getElementById('incompletetable').style.display = '';
                            document.getElementById('incommsg').style.display = 'none';
                        } else {
                            //NO DATA
                            document.getElementById('incompletetable').style.display = 'none';
                            document.getElementById('incommsg').innerHTML = "You have <strong>0</strong> Incomplete Subject";
                            document.getElementById('incommsg').style.display = 'block';
                        }
                    } else {
                        //USER HASNT ENROLL
                    }
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
        </script>