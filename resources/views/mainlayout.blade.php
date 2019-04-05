<html>

<head>
    <title>
       @yield('title')
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="/css/mainlayout.css">
    <!-- FONTS -->
    <link href='https://fonts.googleapis.com/css?family=Cinzel Decorative' rel='stylesheet'>
    <!-- ICONS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
        crossorigin="anonymous">
</head>

<body>
    <div id="topbar" class="sticky-top">
        <!-- TOPBAR -->
        <div id="title">
            <h4 class="float-left" style="font-family: Cinzel Decorative;padding-left: 25px;padding-top: 4px;"><strong>Premier
                    University</strong></h4>
            <div class="float-right">
                <div class="container" style="display: flex">
                    <i class="fas fa-user logos" onclick="window.location='/profile'"></i>
                    <i class="fas fa-power-off logos" onclick="window.location='/logout'"></i>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div id="flex-items">
        <!-- FLEX ITEMS -->
        <div id="sidebar">
            <!-- SIDEBARS -->
            <!-- NAME OR PROFILE -->
            <h4 class="text-center text-white" id="sidebar-title"></h4>
            <hr style="background: white">
            <!-- LIST OF LINK -->
            <ul class="list-group">
                @if(Session::has('admin'))
                <li class="list-group-item all-links {{ Request::is('dashboard') ? 'url_active' : '' }}" onclick="window.location='/dashboard'"><span class="icons"><i class="fab fa-dashcube" ></i></span><span>Dashboard</span></li>
                <li class="list-group-item all-links {{ Request::is('course') || Request::is('addmultiple') ? 'url_active' : '' }}" onclick="window.location='/course'"><span class="icons"><i class="fab fa-discourse" ></i></span><span>Course</span></li>
                <li class="list-group-item all-links {{ Request::is('semester') ? 'url_active' : '' }}" onclick="window.location='/semester'"><span class="icons"><i class="fas fa-university" ></i></span><span>Semester</span></li>
                <li class="list-group-item all-links {{ Request::is('session') ? 'url_active' : '' }}" onclick="window.location='/session'"><span class="icons"><i class="fas fa-adjust"></i></span><span>Session</span></li>
                <li class="list-group-item all-links {{ Request::is('block') ? 'url_active' : '' }}" onclick="window.location='/block'"><span class="icons"><i class="fas fa-ban"></i></span><span>Block</span></li>
                <li class="list-group-item all-links {{ Request::is('result') ? 'url_active' : '' }}" onclick="window.location='/result'"><span class="icons"><i class="fas fa-clipboard"></i></span><span>Result</span></li>
                <li class="list-group-item all-links {{ Request::is('admin/student') ? 'url_active' : '' }}" onclick="window.location='/admin/student'"><span class="icons"><i class="fas fa-user-graduate"></i></span><span>Student</span></li>
                <li class="list-group-item all-links {{ Request::is('admin/teacher') ? 'url_active' : '' }}" onclick="window.location='/admin/teacher'"><span class="icons"><i class="fas fa-chalkboard-teacher"></i></span><span>Teacher</span></li>
                @endif
                @if(session()->has('student'))
                <li class="list-group-item all-links {{ Request::is('student/dashboard') ? 'url_active' : '' }}" onclick="window.location='/student/dashboard'"><span class="icons"><i class="fab fa-dashcube" ></i></span><span>Dashboard</span></li>
                <li class="list-group-item all-links {{ Request::is('enrollment') ? 'url_active' : '' }}" onclick="window.location='/enrollment'"><span class="icons"><i class="fas fa-plus"></i></span><span>Enrollment</span></li>
                <li class="list-group-item all-links {{ Request::is('student/result') ? 'url_active' : '' }}" onclick="window.location='/student/result'"><span class="icons"><i class="fas fa-clipboard"></i></span><span>Result</span></li>
                <li class="list-group-item all-links {{ Request::is('student/reciept') || Request::is('student/payment')  ? 'url_active' : '' }}" onclick="window.location='/student/reciept'"><span class="icons"><i class="fas fa-credit-card"></i></span><span>Payment</span></li>
                @endif
                @if(session()->has('teacher'))
                <li class="list-group-item all-links {{ Request::is('teacher/dashboard') ? 'url_active' : '' }}" onclick="window.location='/teacher/dashboard'"><span class="icons"><i class="fab fa-dashcube" ></i></span><span>Dashboard</span></li>
                <li class="list-group-item all-links {{ Request::is('teacher/students') ? 'url_active' : '' }}" onclick="window.location='/teacher/students'"><span class="icons"><i class="fas fa-user" ></i></span><span>Student</span></li>
                <li class="list-group-item all-links {{ Request::is('teacher/upload') ? 'url_active' : '' }}" onclick="window.location='/teacher/upload'"><span class="icons"><i class="fas fa-upload" ></i></span><span>Upload</span></li>
                @endif
                @if(Session::has('advisor'))
                <li class="list-group-item all-links {{ Request::is('teacher/advising') ? 'url_active' : '' }}" onclick="window.location='/teacher/advising'"><span class="icons"><i class="fab fa-tripadvisor"></i></span><span>Advising</span></li>
                @endif
            </ul>
        </div>
        <div id="contents">
            <!-- CONTENTS -->
            <!-- THIS PART WILL BE YIELDED FOR CONTENTS -->
            <div class="container">
                @yield('rightcontent')
            </div>
        </div>
    </div>
</body>

</html>
