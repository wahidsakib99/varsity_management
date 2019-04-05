@extends('mainlayout')
@section('title')
Teacher | Dashboard
@endsection
@section('rightcontent')
<link rel="stylesheet" href="/css/teacherdashboard.css">
<div class="container">
<h2>Welcome <span><i><h5>{{$name[0]}}</h5></i></span></h2>
    <div class="row-item">
        <h2 class="text-muted text-center">Overview</h2>
        <hr>
        <div class="container flex-item">
            <div id="first" class="container text-white shadow p-3 mb-5">
                <h5>Advisor Of</h5>
            <h6><strong id="advisor_count">{{$advising_count}}</strong> Section</h6>
            </div>
            <div id="second" class="container text-white shadow p-3 mb-5">
                <h5>Listed For </h5>
                <h6><strong id="subject_count">{{$subject_count}}</strong> Subject(s)</h6>
            </div>
            <div id="third" class="container text-white shadow p-3 mb-5">
                <h5>Session</h5>
            <h6 id="session">{{$active_session->year.' '.$active_session->month}}</h6>
            </div>
        </div>
    </div>
    <br>
    <h2 class="text-muted float-left text-blue">Teaching</h2>
    <button class="btn btn-dark float-right" onclick="window.location='/teacher/students'"><u>Show All</u></button>
    <br>
    <hr>
    <ul class="list-group" id="teaching_list">

    </ul>
    <br>
    <div>
        <h2 class="text-muted float-left">Advisng</h2>
        @if(Session::has('advisor'))
        <button class="btn btn-dark float-right" onclick="window.location='/teacher/advising'"><u>Show All</u></button>
        @endif
        
    </div>
    <br>
    <hr>
    <ul class="list-group" id="advising_list">
    </ul>
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
$('document').ready(function(){
    $.ajax({
        url:'getteacherdata',
        method:'get',
        success:function(data)
        {
            var ul_list_teaching = '';
            var ul_list_advising = '';
            if(data['teaching'].length>0)
            {
                for(var i=0;i<data['teaching'].length;i++)
                {
                    ul_list_teaching = ul_list_teaching + "<li class='list-group-item'>"+data['teaching'][i].name+"</li>";
                }
                document.getElementById('teaching_list').innerHTML = ul_list_teaching;
            }
           if(data['advising'].length>0)
           {
            for(var i=0;i<data['advising'].length;i++)
            {
                ul_list_advising = ul_list_advising + "<li class='list-group-item'>"+data['advising'][i]+"</li>";
            }
            
            document.getElementById('advising_list').innerHTML = ul_list_advising;
           }
         
        },
        error:function(e)
        {
            console.log(e);
        },
    })
});
</script>