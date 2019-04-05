@extends('mainlayout')
@section('title')
Admin | Block
@endsection
@section('rightcontent')
<div class="container">
    <button class="btn btn-primary float-right" disabled>Add Block Item</button>
    <br>
    <br>
    <br>
    <div class="container">
        <table class="table table-sm table-hover table-responsive-sm " id="tableblock">
            <thead>
            </thead>
            <tbody id="blocklist">
                @foreach ($data as $d)
                    <tr>
                        <td ><h4><b>{{$d->option_name}}</b></h4></td>
                        <td class=" text-muted"><h6>{{$d->description}}</h5></td>
                        @if($d->active == 1)
                        <td><button class="btn btn-danger" onclick="window  .location='/block_toggle/{{$d->id}}'">Block</button></td>
                        @else
                            <td><button class="btn btn-success" onclick="window .location='/block_toggle/{{$d->id}}'">Unblock</button></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
crossorigin="anonymous"></script>
<!-- Latest compiled JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
crossorigin="anonymous"></script> 