@extends('mainlayout')
@section('title')
Student | Dashboard
@endsection
@section('rightcontent')
<link rel="stylesheet" href="/css/studentdashboard.css">
<?php 
$active_session  = $data['session'];
$count = $data['enrolled'];
$name = $data['name'];
?>
<div class="container">
<h2>Welcome <span><i><h5>{{$name[0]}}</h5></i></span></h2>
    <div class="row-items container">
        <div class="item">
            <h3 class="text-muted text-center">Things To Care</h3>
            <hr>
            <div class="flex-item">
                <div id="first" class="  text-white items shadow p-3 mb-5">
                    <h5>Ongoing Session</h5>
                <h6>{{$active_session->year.' '.$active_session->month}}</h6>
                </div>
                <div id="second" class=" text-white items shadow p-3 mb-5">
                    <h5>Enrolled For</h5>
                <h6><strong>{{$count}}</strong> Subject</h6>
                </div>
                <div id="third" class=" text-white items shadow p-3 mb-5">
                    <h5>Enrollment Status</h5>
                    <h6><strong id="status">On</strong></h6>
                </div>
                <div class=" text-white items shadow p-3 mb-5" id="fourth">
                    <h5>A. CGPA</h5>
                    <h6><strong id="a_cgpa">0.0</strong></h6>
                </div>
            </div>
        </div>
    </div>
    <!-- SMESTER TILE -->
    <div class="row-items container ">
        <div id="item-semester">
            <div id="semester-tile" class="text-white shadow p-3 mb-5">
                <div class="row">
                    <div class="col-sm-1">
                        <div style="border: 5px solid rgb(255, 255, 255);" id="circle-border">
                           <h2 style="margin-left: 17px;margin-top: 17px;" id="c_semester"></h2>
                        </div>
                       
                    </div>
                    <div class="col-sm-1" id="semester-tile-text">
                        <h3>Semester</h3>
                        <h4>Completed</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- INFO ROW -->
    <br>
    <div class="row-items container">
        <button class="btn bg-dark float-right text-white" onclick="window.location='/student/result'"><i class="fas fa-edit"></i>&nbsp;<u>View All</u></button>
        <h3 class="text-muted float-left">Retake/Recourse</h3>
        <br>
        <br>
        <ul class="list-group" id="retake_recourse">
            
        </ul>
    </div>
</div>
<footer style="height: 80px;"></footer>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script>
<script>
    function sup(name)
    {
        if(name === '1')
            return name+"<sup>st</sup>";
        else if(name === 2)
            return name+"<sup>nd</sup>";
        else if(name === 3)
            return name+"<sup>rd</sup>";
        else
            return name+"<sup>th</sup>";
    }
    $('document').ready(function()
    {
        $.ajax({
            url:'getstudentdashdata',
            method:'get',
            success:function(data)
            { 
                if(data['cgpa'] !==null)
                    document.getElementById('a_cgpa').innerHTML = data['cgpa'].toFixed(2);
                else
                    document.getElementById('a_cgpa').innerHTML = '0.0';
                
                if(data['user_has_completed_semester'] === true)
                {
                    document.getElementById('c_semester').innerHTML = sup(data['semester']);
                }
                else
                {
                    document.getElementById('c_semester').innerHTML = "0<sup>th</sup>";
                }
                var ul_li = '';
                for(var i=0;i<data['retake'].length;i++)
                {
                    ul_li = ul_li+"<li class='list-group-item'>"+data['retake'][i].subname+"</li>";
                }
                document.getElementById('retake_recourse').innerHTML = ul_li;
            },
            error:function(e)
            {       
                console.log(e);
            },
        });
    });
</script>