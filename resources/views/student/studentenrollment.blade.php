@extends('mainlayout')
@section('title')
Student | Enrollment
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container">
    <div id="msg" style="display: none"></div>
</div>

<div class="container">
    <h3 id="semesterno" class="float-left"></h3>
    <br>
    <hr>
    <ul class="nav nav-tabs">
        <li class=" nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Section<span class="caret"></span></a>
            <ul class="dropdown-menu" id="sectionslist" style="max-height: 180px; overflow-y: auto">
            </ul>
        </li>
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#subjects">Enroll</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending" onclick="showpending();">Pending</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#approved" onclick="showapproved()">Approved</a></li>
    </ul>
    <div class="tab-content">
        <div id="subjects" class="tab-pane fade show active " style="background: white">
            <table class="table table-sm text-center" id="enrolltable" style="max-height: 73%;overflow-y: auto">
                <thead>
                    <tr class="table-info">
                        <th><input type="checkbox" id="checkingall" onchange="checkall()"></th>
                        <th>Subject</th>
                        <th>Course Code</th>
                        <th>Credit</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="enrolltbody">

                </tbody>
            </table>
            <center> <button type="button" class="btn btn-success" id="enroll" onclick="postenroll()"><span class="glyphicon glyphicon-ok-sign"></span>Enroll</button>
        </div>
        {{-- PENDING TAB --}}
        <div id="pending" class="tab-pane fade in" style="background: white">
            <table class="table table-sm text-center" id="pendingtable" style="max-height: 73%;overflow-y: auto">
                <thead>
                    <tr class='table-info'>
                        <th>Subject</th>
                        <th>Course Code</th>
                        <th>Credit</th>
                        <th>Section</th>
                        <th>Type</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="pendingtbody">

                </tbody>
            </table>
        </div>
        {{-- APPROVED TAB --}}
        <div id="approved" class="tab-pane fade in" style="background: white">
            <table class="table table-sm text-center" id="approvedtable" style="max-height: 73%;overflow-y: auto">
                <thead>
                    <tr class='table-info'>
                        <th>Subject</th>
                        <th>Course Code</th>
                        <th>Credit</th>
                        <th>Section</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id="approvedtbody">

                </tbody>
            </table>
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
        var percredit_regular = 1500;
        var percredit_retake = 500;
        var percredit_recourse = 2000;

        function hidemsg() {
            var n = document.getElementById('msg');
            n.style.display = 'none';
        }

        function credit_value(type) {
            if (type === 0)
                return 1500;
            else if (type === 1)
                return 500;
            else
                return 2000;
        }
        $('document').ready(function () {
            $.ajax({
                url: 'sectionlist',
                method: 'get',
                success: function (data) {
                    if (data['nosession'] === false) {
                        if (data['success'] === true) {
                            var sectionlist = data['section'];
                            var list = '';
                            for (var i = 0; i < sectionlist.length; i++) {
                                list = list + "<li onclick='showsubjects(" + sectionlist[i].id + ")' style='cursor:pointer'><a class='dropdown-item'>" + sectionlist[i].name + "</a></li>"
                            }
                            document.getElementById('sectionslist').innerHTML = list;
                            showsubjects(sectionlist[0].id);
                        } else {
                            document.getElementById('msg').innerHTML = "<div class='alert alert-danger'> No section has been created for this session yet</div>";
                            var hide = setTimeout(hidemsg,4000);s
                        }
                    } else {
                       document.getElementById('msg').innerHTML = "<div class='alert alert-danger'>No Section</div>";
                        var hide = setTimeout(hidemsg,4000);
                    }
                },
                error: function (e) {
                    console.log(e);
                },
            });
        });
        var section_name_global;

        function showsubjects(id) {
            $.ajax({
                url: 'studentshowsubjects/' + id,
                method: 'get',
                success: function (data) {
                    section_name_global = data['section_id'];
                    document.getElementById('semesterno').innerHTML = "Section: " + data['name'];
                    var subs = data['data'];
                    var tablerow = '';
                    for (var i = 0; i < subs.length; i++) {
                        tablerow = tablerow + "<tr><td><input name='secs[]' type='checkbox' value=" + subs[i].id + "></td><td>" + subs[i].name + "</td><td>" + subs[i].code + "</td><td>" + subs[i].credit + "</td><td><select class='form-control form-control-sm' id=" + subs[i].id + "><option value='0'>Regular</option><option value='1'>Retake</option><option value='2'>Recourse</option></select></td></tr>";
                    }
                    document.getElementById('enrolltbody').innerHTML = tablerow;
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function checkall() {
            var all_subjects = document.getElementsByName('secs[]');
            if (document.getElementById('checkingall').checked) {
                for (var i = 0; i < all_subjects.length; i++) {
                    all_subjects[i].checked = true;
                }
            } else {
                for (var i = 0; i < all_subjects.length; i++) {
                    all_subjects[i].checked = false;
                }
            }
        }


        function type(t) // t=type
        {
            var name;
            if (t === 0)
                name = "Regular";
            else if (t === 1)
                name = "Retake";
            else
                name = "Recourse";

            return name;

        }

        function showpending() {
            $.ajax({
                url: 'studentshowpending',
                method: 'get',
                success: function (data) {
                    if (data['redirect'] === false) {
                        if (data['nodata'] === false) {
                            var datas = data['data'];
                            var tablerow = '';
                            var total_cost = 0;
                            var cost = data['cost'];
                            //COUNT CREDIT
                            for (var i = 0; i < datas.length; i++) {
                                if (datas[i].type === 0) {
                                    total_cost = total_cost + datas[i].credit * cost.regular_values;
                                } else if (datas[i].type === 1) {
                                    total_cost = total_cost + datas[i].credit * cost.retake_values;
                                } else {
                                    total_cost = total_cost + datas[i].credit * cost.recourse_values;
                                }
                                tablerow = tablerow + "<tr><td>" + datas[i].subname + "</td><td>" + datas[i].code + "</td><td>" + datas[i].credit + "</td><td>" + datas[i].secname + "</td><td>" + type(datas[i].type) + "</td><td><button class='btn btn-danger' onclick='deletepending(" + datas[i].id + ")'>Delete</button></td></tr>";
                            }
                            document.getElementById('pendingtbody').innerHTML = tablerow + "<tr><td colspan='4'></td><td><label>Total</label></td><td><label>" + total_cost + "/=</label></td></tr>";
                            document.getElementById('pendingtable').style.display = '';
                        } else {
                            document.getElementById('pendingtable').style.display = 'none';
                            var errors = "<div class='alert alert-danger'><strong></strong>&nbsp;Nothing Pending.</div>";
                            document.getElementById('msg').innerHTML = errors;
                            document.getElementById('msg').style.display = 'block';
                            var hide = setTimeout(hidemsg, 4000);
                        }
                    } else {
                        window.location.href = '/';
                    }
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function showapproved() {
            $.ajax({
                url: 'showapproved',
                method: 'get',
                success: function (data) {
                    if (data['redirect'] !== true) {
                        if (data['nodata'] === false) {
                            var datas = data['data'];
                            var cost = data['cost'];
                            var tablerow = '';
                            total_cost = 0;
                            for (var i = 0; i < datas.length; i++) {
                                if (datas[i].type === 0) {
                                    total_cost = total_cost + datas[i].credit * cost.regular_values;
                                } else if (datas[i].type === 1) {
                                    total_cost = total_cost + datas[i].credit * cost.retake_values;
                                } else {
                                    total_cost = total_cost + datas[i].credit * cost.recourse_values;
                                }
                                tablerow = tablerow + "<tr><td>" + datas[i].subname + "</td><td>" + datas[i].code + "</td><td>" + datas[i].credit + "</td><td>" + datas[i].secname + "</td><td>" + type(datas[i].type) + "</td></tr>";
                            }
                            document.getElementById('approvedtbody').innerHTML = tablerow + "<tr><td colspan='3'></td><td><label>Total</label></td><td><label>" + total_cost + "/=</label></td></tr>";
                            document.getElementById('approvedtable').style.display = '';
                        } else {
                            document.getElementById('approvedtable').style.display = 'none';
                            var errors = "<div class='alert alert-danger'><strong></strong>&nbsp;Nothing Approved.</div>";
                            document.getElementById('msg').innerHTML = errors;
                            document.getElementById('msg').style.display = 'block';
                            var hide = setTimeout(hidemsg, 4000);
                        }
                    } else {
                        window.location.href = '/';
                    }
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function deletepending(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'deletepending/' + id,
                method: 'post',
                success: function (data) {
                    if (data['user'] === true) {
                        if (data['delete'] === true) {
                            showpending();
                        }
                    } else {
                        console.log('WELL PLAYED');
                    }

                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function postenroll() {
            var subjects_id = document.getElementsByName('secs[]'); //subjects
            var section_id = section_name_global;
            var checked_subjects_id = [];
            var checked_subjects_id_type = [];
            // var type = document.getElementBy('type').value;
            var count_helper = 0;
            for (var i = 0; i < subjects_id.length; i++) {
                if (subjects_id[i].checked) {
                    checked_subjects_id[count_helper] = subjects_id[i].value;
                    checked_subjects_id_type[count_helper] = document.getElementById(subjects_id[i].value).value;
                    count_helper++;
                }
            }
            if (checked_subjects_id.length > 0) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: 'postenroll',
                    method: 'post',
                    data: {
                        subjects_id: checked_subjects_id,
                        type: checked_subjects_id_type,
                        section: section_name_global
                    },
                    success: function (data) {
                        if (data['nosession'] === false) {
                            if (data['max'] === false) {
                                if (data['success'] === true) {
                                    var errors = "<div class='alert alert-success'><strong></strong>&nbsp;Enrolled Successfully!!</div>";
                                    document.getElementById('msg').innerHTML = errors;
                                    document.getElementById('msg').style.display = 'block';
                                    var hide = setTimeout(hidemsg, 4000);
                                } else {
                                    var errorstart = "<div class='alert alert-danger'><strong></strong>&nbsp<ul>";
                                    var errorend = "</ul></div";
                                    var errors = '';
                                    var failed = data['failed'];

                                    for (var i = 0; i < failed.length; i++) {
                                        errors = errors + "<li>" + failed[i] + "</li>";
                                    }
                                    document.getElementById('msg').innerHTML = errorstart + errors + errorend;
                                    document.getElementById('msg').style.display = 'block';
                                    var hide = setTimeout(hidemsg, 7000);
                                }
                            } else {
                                var errors = "<div class='alert alert-danger'><strong></strong>&nbsp;No seats available.</div>";
                                document.getElementById('msg').innerHTML = errors;
                                document.getElementById('msg').style.display = 'block';
                                var hide = setTimeout(hidemsg, 4000);
                            }
                        } else {
                            var errors = "<div class='alert alert-danger'><strong></strong>&nbsp;Could not find active session.Please contact your Advisor.</div>";
                            document.getElementById('msg').innerHTML = errors;
                            document.getElementById('msg').style.display = 'block';
                            var hide = setTimeout(hidemsg, 4000);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            } else {
                var errors = "<div class='alert alert-danger'><strong></strong>&nbsp;Please select At least one subject.</div>";
                document.getElementById('msg').innerHTML = errors;
                document.getElementById('msg').style.display = 'block';
                var hide = setTimeout(hidemsg, 4000);
            }

        }
    </script>
