@extends('mainlayout')
@section('title')
Student |Reciept
@endsection
@section('rightcontent')
<?php 
?>
<div class="container">
    @if ($error == false)
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong>{{$profile[0]->name}}</strong>
                        <br>
                        Section: {{$secname}}
                        <br>
                        Advisor: {{$advisor_name}}
                        <br>
                        Session: {{$session->year.' '.$session->month}}
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>Date: @if($paid == true) {{$payment_data->date}} @else {{date('Y-m-d')}} @endif</em>
                    </p>
                    <p>
                        <em>Receipt #: @if($paid == true) {{$payment_data->reference}} @else ###### @endif</em>
                    </p>
                    <p>
                        <em>Status : @if($paid == true) Paid @else Unpaid @endif </em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1 style="margin-left: 150%;">Receipt</h1>
                </div>
                </span>
                <table class="table tale-sm text-center">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Type</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ( $i= 0; $i < count($datas); $i++) <tr>
                            <td class="col-md-9"><em>{{$datas[$i]->subname}}</em></h4>
                            </td>
                            <td class="col-md-1" style="text-align: center"> @if($datas[$i]->type == 0)Regular
                                @elseif($datas[$i]->type == 1)Retake @elseif($datas[$i]->type == 2) Recourse @endif
                            </td>
                            <td class="col-md-1 text-center">{{$datas[$i]->subcredit}}</td>
                            <td class="col-md-1 text-center">{{$sub_value[$i].'/='}}</td>
                            </tr>
                            @endfor
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td class="text-right">
                                    <h4><strong>Total: </strong></h4>
                                </td>
                                <td class="text-center text-danger">
                                    <h4><strong>{{$total.'/='}}</strong></h4>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <form method="GET" action="/student/payment/{{$total}}">
                @if($paid == false)
                @if($subject_count == 1)
                <button type="submit" class="btn btn-success btn-lg btn-block">
                    Pay Now   <span class="glyphicon glyphicon-chevron-right"></span>
                </button>
                @else
                <h3 class='text-muted'>Your Enrollment has not completed.Wait for your advisor to accept.</h3>
                @endif
                @else
                <button type="button" class="btn btn-danger btn-lg btn-block" onclick="window.location='makepdf'">
                    Download Copy   <span class="glyphicon glyphicon-chevron-download"></span>
                </button>
                @endif
            </form>

        </div>
    </div>

    @else
    <div class="alert alert-danger">
        <ul>
            <li>{{ $error }}</li>
        </ul>
    </div>
    @endif
@endsection