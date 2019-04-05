@extends('mainlayout')
@section('title')
Admin | Semester
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="container">
    <div id="msg" style="display: none;">@if($error) <div class="alert alert-danger">{{$error}}</div>@endif</div>
    <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#myModal">Add
        Semester</button>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" style="overflow-y:auto ; height: 73%;">
                <table id="mytable" class="table table-sm text-center">
                    <thead>
                        <tr class="table-info">
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Active/Block</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="semestertbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Semester <span id="semname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="deletedata()">Yes</button>
            </div>
        </div>
    </div>
</div>
{{-- MODAL FOR ADDING SEMESTER --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="addsemester" method="POST">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                    <h4 class="modal-title text-muted">Add Semester</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr"><strong>Add Semester Name</strong>:</label>
                        <input type="number" class="form-control" id="sems" name="semester_name" required placeholder="e.g 1 or 2">
                            <br>
                        <h4 class="text-muted text-center border-bottom">Course Fee</h4>
                        <label for="regular"><strong>Regular:</strong> </label><input type="number" class="form-control form-control-sm" id="regular" name="regular"required>
                        <label for="retake"><strong>Retake:</strong> </label><input type="number" class="form-control form-control-sm" id="retake" name="retake" required>
                        <label for="recourse"><strong>Recourse:</strong> </label><input type="number" class="form-control form-control-sm" id="recourse" name="recourse" required>
                        <div id="errmsg" style="display: none; background: #facccc;color: #f04444;margin-top: 4px;padding: 4px 4px 4px 4px;">Please
                            Fill Up Every Section</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="add_semester_button" onclick="control_semester()">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </form>
    </div>
</div>
<script>
        function control_semester() {
            var sems = document.getElementById('sems');
            var regular = document.getElementById('regular');
            var retake = document.getElementById('retake');
            var recourse = document.getElementById('recourse');
            if (sems.value === '' || regular.value == '' || retake.value == '' || recourse.value == '') {
                document.getElementById('errmsg').style.display = 'block';
            } else
                document.getElementById('add_semester_button').setAttribute('type', 'submit');

        }

</script>
{{-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Semester <span id="semname"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="deletedata()">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="deletem" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        ...
        Delete Semester <span id="semname"></span>
      </div>
    </div>
  </div> --}}

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script> 
<script>
        function hidmsg() {
            document.getElementById('msg').style.display = 'none';
        }

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

        function active(status) {
            if (status === 1) {
                return 'Active';
            } else {
                return 'Inactive';
            }
        }

        function setbutton(id, active) {
            if (active === 1) {
                return '<button class="btn btn-dark" onclick="enabledisable(' + id + ',1)">Disable</button>';
            } else {
                return '<button class="btn btn-success" onclick="enabledisable(' + id + ',0)">Enable</button>';
            }
        }
        $('document').ready(function () {
            getsemester();
        });

        function getsemester() {
            $.ajax({
                url: 'getsemester',
                method: 'get',
                success: function (data) {
                    var semester = data;
                    var tablerow = '';
                    if (semester.length > 0) {
                        for (var i = 0; i < semester.length; i++) {
                            tablerow = tablerow + "<tr><td>" + sup(semester[i].name) + "</td><td>" + active(semester[i].active) + "</td><td>" + setbutton(semester[i].id, semester[i].active) + "</td><td><button class ='btn btn-danger' onclick='deletemodal(" + semester[i].id + ")'>Delete</button></td></tr>";
                        }
                        document.getElementById('semestertbody').innerHTML = tablerow;
                        document.getElementById('mytable').style.display = ' ';
                    } else {
                        document.getElementById('mytable').style.display = 'none';
                    }

                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function enabledisable(id, active) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'enabledisable/' + id + '/' + active,
                method: 'post',
                success: function (data) {
                    if (data['update'] === true) {
                        document.getElementById('msg').innerHTML = "<div class='alert alert-success'>Successfully updated.</div>";
                        document.getElementById('msg').style.display = '';
                    } else {
                        document.getElementById('msg').innerHTML = "<div class='alert alert-danger'>Failed to update.</div>";
                        document.getElementById('msg').style.display = '';
                    }
                    getsemester();
                    var hide = setTimeout(hidmsg, 4000);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        var global_semester;

        function deletemodal(id) {
            $.ajax({
                url: 'showmodaldata/' + id,
                method: 'get',
                success: function (data) {
                    document.getElementById('semname').innerHTML = "<strong>" + sup(data[0].name) + "</strong>";
                    $('#deleteModal').modal('show');
                    global_semester = id;
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }

        function deletedata() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'deletesemester/' + global_semester,
                method: 'post',
                success: function (data) {
                    if (data['delete'] === true) {
                        $('#deleteModal').modal('hide');
                        document.getElementById('msg').innerHTML = "<div class='alert alert-success'>Successfully deleted.</div>";
                        document.getElementById('msg').style.display = '';
                    } else {
                        document.getElementById('msg').innerHTML = "<div class='alert alert-danger'>Failed to delete.</div>";
                        document.getElementById('msg').style.display = '';
                    }
                    getsemester();
                    var hide = setTimeout(hidmsg, 4000);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    </script>