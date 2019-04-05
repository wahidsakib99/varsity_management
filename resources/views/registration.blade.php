<html>
    <head>
        <title>
            Registration 
        </title>
        <link rel="stylesheet" href="/css/registration.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </head>
    <body>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
                <ul>
                    <li>{{ Session::get('error') }}</li>
                </ul>
            </div>
        @endif
        <form action="register" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="container" style="background: rgb(243, 243, 243)">
            <h2 class="text-center text-muted">Registration</h2>
            <hr>
            <div class="container border items">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Name:</h6>
                    </div>
                    <div class="col-md-6">
                    <input name="uname" type="text" class="form-control form-control-sm" required placeholder="Type Your Name Here" value="{{old('uname')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>ID</h6>
                    </div>
                    <div class="col-md-6">
                    <input name="uid" type="number" required class="form-control form-control-sm" placeholder="Type Your ID" value="{{old('uid')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Password:</h6>
                    </div>
                    <div class="col-md-6">
                        <input name="upass" type="password" required class="form-control form-control-sm" placeholder="At leat 8 Character">
                    </div>
                </div>
                <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2">
                            <h6>Email</h6>
                        </div>
                        <div class="col-md-6">
                        <input name="email" type="email" required class="form-control form-control-sm" placeholder="Type a valid email" value="{{old('email')}}">
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Address:</h6>
                    </div>
                    <div class="col-md-6">
                        <textarea name="uaddress" id="" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Birth Date:</h6>
                    </div>
                    <div class="col-md-6">
                    <input name="bdate" type="date" class="form-control form-control-sm" required value="{{old('bdate')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Gender: </h6>
                    </div>
                    <div class="col-md-6">
                        <select name="gender"  class="form-control form-control-sm">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Role: </h6>
                    </div>
                    <div class="col-md-6">
                        <select name="role"  class="form-control form-control-sm">
                            <option value="1">Student</option>
                            <option value="2">Teacher</option>
                        </select>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Phone No:</h6>
                    </div>
                    <div class="col-md-6">
                    <input name="phone" type="number" class="form-control form-control-sm" required placeholder="+880XXXXXXXX" value="{{old('phone')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <h6>Upload Photo:</h6>
                    </div>
                    <div class="col-md-6">
                        <input name="photo" type="file" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <button  type="submit" class="btn btn-secondary text-white text-center"><i class="fas fa-cloud-upload-alt"></i>&nbsp;Submit</button>
                    </div>
                    <div class="col-sm-5"></div>
                </div>
                
            </div>
        </div>
    </form>   
    </body>
    <footer style="height: 80px;"></footer>
</html>