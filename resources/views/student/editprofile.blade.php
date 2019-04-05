@extends('mainlayout')
@section('title')
Student | Profile
@endsection
@section('rightcontent')
@if (!$error)
@foreach ( $data as $d )
<div class="container-fluid">
    <section class="panel">
        <div class="panel-body bio-graph-info" style="overflow-y: auto;">
            <h1 class="text-muted"> Edit Info</h1>
            <hr>
            <form class="form-horizontal" role="form" method="POST" action="/student/saveprofile/{{$d->id}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-lg-2 control-label">Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="name" placeholder={{$d->name}} value={{old('name')}}>
                        @if ($errors->has('name'))<p style="color:red">Fill Up Name Correctly</p> @endif
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="col-lg-2 control-label">About Me</label>
                    <div class="col-lg-10">
                        <textarea name="" name="" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div> --}}
                {{-- <div class="form-group">
                    <label class="col-lg-2 control-label">Country</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="c-name" placeholder=" ">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="col-lg-2 control-label">Birthday</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="bdate" placeholder={{$d->bdate}} value={{old('bdate')}}>
                        @if ($errors->has('bdate'))<p style="color:red">Not a valid Birthday</p> @endif
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="col-lg-2 control-label">Occupation</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="occupation" placeholder=" ">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-6">
                        <input type="email" class="form-control" name="email" placeholder={{$d->email}} value={{old('email')}}>
                        @if ($errors->has('email'))<p style="color:red">Not a valid email</p> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Mobile</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="mobile" placeholder={{$d->phoneno}} value={{old('mobile')}}>
                        @if ($errors->has('mobile'))<p style="color:red">'Phone No.' required</p> @endif
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="col-lg-2 control-label">Website URL</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="url" placeholder="http://www.demowebsite.com ">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="col-lg-2 control-label">Gender</label>
                    <div class="col-lg-6">
                        <select name="gender" class="form-control form-control-sm">
                            <option value="M">MALE</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        {{-- <button type="button" class="btn btn-danger">Cancel</button> --}}
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endforeach
@else
@endif
@endsection