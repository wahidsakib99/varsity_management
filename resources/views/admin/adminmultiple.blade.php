@extends('mainlayout')
@section('title')
Student | Enrollment
@endsection
@section('rightcontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container">
    <h3 class="modal-title float-left text-center text-muted">Add Course</h3>
    <div id="msg" style="display: none"></div>
    <div class="form-group">
        <select class="form-control form-control-sm" name="semester" id="value_of_semester">
        </select>
        <br>
        <table class="table table-sm table-hover table-responsive-sm" >
            <thead class="table-primary">
                <th></th>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Credit</th>
                <th></th>
            </thead>
            <tbody id="multiplerow" class="text-center">

            </tbody>
        </table>
        <br>
        <button class="btn btn-success float-left" onclick="save()"><i class="fas fa-cloud-download-alt"></i>&nbsp;&nbsp;Save</button>
        <button class="btn btn-outline-dark float-right" onclick="create_row()" style="margin-right: 2%;"><i class="fas fa-plus"></i></button>
        <footer style="height: 140px;"></footer>
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
    var max_row =10;
    var row_count=0;
    var current_row = 0;
function hidemsg()
{
    document.getElementById('msg').style.display = 'none';
}
function sup(name)
    {
        var sup;
        if(name === '1')
        {
            sup = name+"<sup>st</sup>";
        }
        else if(name === '2')
        {
         sup = name+"<sup>nd</sup>";
        }
        else if(name === '3')
        {
         sup = name+"<sup>rd</sup>";
        }
        else
         sup = name+"<sup>th</sup>";

        return sup;
    }
$('document').ready(function(){
    create_row();
    $.ajax({
        url:'/showsemesters',
        method:'get',
        success:function(data)
        {
            var li= '';
            for(i=0;i<data['data'].length;i++)
            {
                li = li+ "<option value = '"+data['data'][i].id+"'>"+sup(data['data'][i].name)+"&nbsp;Semester</option>";
            }
            document.getElementById('value_of_semester').innerHTML = li;

        },
        error:function(e)
        {
            console.log(e);
        }
    });
});
function create_row()
{
    row_count++;
    var row_start = '<tr id='+current_row+'>';
    var row_course_name = '';
    var row_course_code = '';
    var row_course_credit= '';
    var row_minus        = '';
    var row_count_html = '';
    var row_end = '</tr>'
    final_row = '';
    for( current_row;current_row<row_count;current_row++)
    {
        if($('#multiplerow tr').length<max_row)
        {
            row_count_html = '<td><b>#'+(current_row+1)+'</b></td>';
            row_course_name = "<td><input type='text' name='course_name[]' class='form-control form-control-sm'></td>";
            row_course_code = "<td><input type='text' name='course_code[]' class='form-control form-control-sm'></td>";
            row_course_credit = "<td><input type='number' name='course_credit[]' class='form-control form-control-sm'></td>";
            row_minus = "<td><button class='btn btn-outline-danger' onclick='remove_row("+current_row+")'><i class='fas fa-minus'></i></button></td>";
            final_row = row_start + row_count_html+ row_course_name + row_course_code + row_course_credit+ row_minus;
            $('#multiplerow').append(final_row);
        }
    }
}

function remove_row(row_number)
{
    $('#'+row_number).remove();
}
function save()
{
    var error_check = false;
    var course_name = document.getElementsByName('course_name[]');
    var course_code = document.getElementsByName('course_code[]');
    var course_credit = document.getElementsByName('course_credit[]');
    var course_name_array = [];
    var course_code_array = [];
    var course_credit_array = [];
    if(course_name.length >0)
    {
        for(var i = 0; i<course_name.length;i++)
        {
            if(course_name[i].value === '' || course_code[i].value === '' || course_credit[i].value === '' || isNaN(course_credit[i]) == false )
            {
                error_check = true;
                console.log(error_check);
            }
            else
            {
                course_name_array[i] = course_name[i].value;
                course_code_array[i] = course_code[i].value;
                course_credit_array[i] = course_credit[i].value;
            }
        }
    }
    else{
        error_check = true;
    }


    if(error_check === false)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            url: 'savemultiple',
            method:'post',
            data:{course_name: course_name_array,
                  course_code: course_code_array,
                  course_credit: course_credit_array,
                  semester: document.getElementById('value_of_semester').value,
            },
            success:function(data)
            {
               if(data['insert'] === true)
               {
                document.getElementById('msg').innerHTML = "<div class='alert alert-primary'>****  Successfully inserted   ****</div>";
                document.getElementById('msg').style.display = '';
                var hide = setTimeout(hidemsg,3000);
               }
               else
               {
                document.getElementById('msg').innerHTML = "<div class='alert alert-danger'>****  Some data may exist   ****</div>";
                document.getElementById('msg').style.display = '';
                var hide = setTimeout(hidemsg,3000);
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
        document.getElementById('msg').innerHTML = "<div class='alert alert-info'>****  Please fill up all form Correctly   ****</div>";
        document.getElementById('msg').style.display = '';
        var hide = setTimeout(hidemsg,3000);

    }

}
</script>