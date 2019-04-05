@extends('mainlayout')
@section('title')
Admin | Student
@endsection
@section('rightcontent')
<div class="container">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-3">
            
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" placeholder="Search Teacher...." id="search">
            <div class="container" id="msg" style="display: none;margin-top: 5px;"><h6 class="text-muted">No Result</h3></div>
        </div>
    </div>
    <br>
 <div class="row">
     <div class="col-md-1">

     </div>
     <div class="col-md-10">
        <!-- ADDING CODE -->
        {{-- SEARCHING TABLE --}}
        <table class="table table-sm border" id="studentsearchtable" style="display: none">
                <thead>
                    <tr>
                     <th></th>
                     <th>Name</th>
                     <th>Teacher ID</th>
                     <th>Email</th>
                     <th>Status</th>
                     <th>Update</th>
                    </tr>
                </thead>
                <tbody id="studentsearchtbody">
                </tbody>
            </table>
            
        {{-- SEARCHING TABLE END --}}
        <table class="table table-sm border" id="studenttable">
            <thead>
                <tr>
                 <th></th>
                 <th>Name</th>
                 <th>Teacher ID</th>
                 <th>Email</th>
                 <th>Status</th>
                 <th>Update</th>
                </tr>
            </thead>
            <tbody id="studenttbody">
                @foreach ($data as $d)
                <tr>
                    <td><img src="/images/{{$d->image}}" style="height:25px;width: 25px;" class="rounded-circle"></td>
                    <td>{{$d->name}}</td>
                    <td>{{$d->user_id}}</td>
                    <td>{{$d->email}}</td>
                    @if ($d->active == 1)
                    <td>Active</td> 
                <td><a class="btn btn-danger" href='teacherdisable/{{$d->user_id}}'>Disable</a></td>
                    @else
                    <td>Disabled</td> 
                <td><a class="btn btn-success" href='teacherenable/{{$d->user_id}}'>Enable</a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{$data->links()}}
     </div>
     <div class="col-md-1">
         
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
$('document').ready(function () {

    $('#search').keyup(function () {
        var search_string = document.getElementById('search').value;
        if (search_string === ' ' || !document.getElementById('search').value) {
            document.getElementById('studenttable').style.display = '';
            document.getElementById('studentsearchtable').style.display = 'none';
            document.getElementById('msg').style.display = 'none';
        } else {
            $.ajax({
                url: 'getteachersearchresult/' + document.getElementById('search').value,
                method: 'get',
                success: function (data) {
                    var tablerow = '';
                    if (data['student'].length === 0 && data['id'].length === 0) {
                        document.getElementById('studentsearchtable').style.display = 'none';
                        document.getElementById('studenttable').style.display = '';
                        document.getElementById('msg').style.display = '';
                    } else {
                        document.getElementById('studentsearchtable').style.display = '';
                        document.getElementById('studenttable').style.display = 'none';
                        document.getElementById('msg').style.display = 'none';
                        var activeOrInactive;
                        var button;
                        for (var i = 0; i < data['student'].length; i++) {
                            if (data['student'][i].teacher === 1) {
                                activeOrInactive = "Active";
                                button = "<a class='btn btn-danger' href='teacherdisable/" + data['student'][i].user_id + "'>Disable</a>";
                            } else {
                                activeOrInactive = "Inactive";
                                button = "<a class='btn btn-success' href='teacherenable/" + data['student'][i].user_id + "'>Enable</a>";
                            }
                            tablerow = tablerow + "<tr><td><img src='/images/" + data['student'][i].image + "' style='height:25px;width: 25px;' class='rounded-circle'></td><td>" + data['student'][i].name + "</td><td>" + data['student'][i].user_id + "</td><td>" + data['student'][i].email + "</td><td>" + activeOrInactive + "</td><td>" + button + "</td></tr>";
                        }
                        for (var i = 0; i < data['id'].length; i++) {
                            if (data['id'][i].student === 1) {
                                activeOrInactive = "Active";
                                button = "<button class='btn btn-danger' href='teacherdisable/" + data['id'][i].user_id + "'>Disable</button>";
                            } else {
                                activeOrInactive = "Inactive";
                                button = "<button class='btn btn-success' href='teacherenable/" + data['id'][i].user_id + "'>Enable</button>";
                            }
                            tablerow = tablerow + "<tr><td><img src='/images/" + data['id'][i].image + "' style='height:25px;width: 25px;' class='rounded-circle'></td><td>" + data['id'][i].name + "</td><td>" + data['id'][i].user_id + "</td><td>" + data['id'][i].email + "</td><td>" + activeOrInactive + "</td><td>" + button + "</td></tr>";
                        }
                        document.getElementById('studentsearchtbody').innerHTML = tablerow;
                    }

                },
                error: function (e) {
                    console.log(e);
                }

            })
        }

    });
})

</script>