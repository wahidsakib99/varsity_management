<style>
        .tbl{
            border: 1px solid black;
        }
        </style>
        <html>
            <head>
        {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  --}}
        {{-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}
            </head>
            <body>
        <!------ Include the above in your HEAD tag ---------->
        <?php 
        $datas = $data['datas'];
        $profile = $data['profile'];
        $sub_value = $data['sub_value'];
        ?>
        <div class="container">
        @if ($data['error'] == false)
            <div class="row">
                <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6" style="float: left;">
                            <address>
                                <strong>{{$profile[0]->name}}</strong>
                                <br>
                                Section: {{$data['secname']}}
                                <br>
                                Advisor: {{$data['advisor_name']}}
                                <br> 
                                Session: {{$data['session']->year.' '.$data['session']->month}}
                            </address>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 text-right" style="float: right;">
                            <p>
                            <em>Date: @if($data['paid'] == true) {{$data['payment_data']->date}} @else {{date('Y-m-d')}} @endif</em>
                            </p>
                            <p>
                            <em>Receipt #: @if($data['paid'] == true) {{$data['payment_data']->reference}} @else ###### @endif</em>
                            </p>
                            <p>
                                <em>Status :  @if($data['paid'] == true) Paid @else Unpaid @endif </em>
                            </p>
                        </div>
                    </div>
                    <div  style="text-align: center">
                        <div  style="margin-top:1in;margin-left: 22%;">
                            <h1>Receipt</h1>
                        </div>
                        <div style="margin-left: 19%;width: 100%;">
                        <table style="">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th >Type</th>
                                    <th >Credit</th>
                                    <th >Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @for ( $i= 0; $i < count($datas); $i++)
                                <tr class="tbl">
                                <td><em>{{$datas[$i]->subname}}</em></h4></td>
                                <td style="text-align: center"> @if($datas[$i]->type == 0)Regular @elseif($datas[$i]->type == 1)Retake @elseif($datas[$i]->type == 2) Recourse @endif </td>
                                <td style="text-align: center">{{$datas[$i]->subcredit}}</td>
                                <td style="text-align: center">{{$sub_value[$i].'/='}}</td>
                                </tr>
                            @endfor
                                <tr>
                                    <td>   </td>
                                    <td>   </td>
                                    <td ><h4><strong>Total: </strong></h4></td>
                                    <td class="text-center text-danger"><h4><strong>{{$data['total'].'/='}}</strong></h4></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        </body>
        </html>