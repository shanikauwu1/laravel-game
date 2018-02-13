<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>



        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Game Of Life
                </div>

                <!-- Main content -->
                <section class="content">
                    <!-- place view details starts -->
                    <div class="box">
                        <div class="row">
                            <button id="next">Next</button>&nbsp;
                            <button id="play">Play</button>&nbsp;
                            <button id="pause">Pause</button>&nbsp;<br/><br/>
                        </div>
                        <table class="table-bordered" id="data_grid_all">
                            <tbody>
                            @for($x = 0; $x < 38; $x++)
                                <tr>
                                @for ($y = 0; $y < 38; $y++)
                                  <td style="width: 10px;height: 10px;" id="{!! $x."_".$y !!}"></td>
                                @endfor
                                </tr>
                            @endfor


                            </tbody>
                        </table>

                    </div>
                    <!-- place view details ends-->
                </section>
                <!-- /.content -->
            </div>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            var data_grid = {!! json_encode($game_data) !!};
            var p=0; var autoplay=0;
            $(function() {
                function colourGrid(data_set,l) {
                    $('#data_grid_all').css("background-color","#fff");
                    var data=data_set[l];
                    if (typeof data !== 'undefined' && data.length >0) {
                        for(var i=0;i<data.length;i++){
                            if (typeof data[i] !== 'undefined' && data[i].length >0) {
                                console.log(data[i]);
                                for(var j=0;j<data[i].length;j++){
                                    if(data[i][j]==1){
                                        $('#'+i+'_'+j).css("background-color","#1127DD");
                                    }
                                    else{
                                        $('#'+i+'_'+j).css("background-color","#fff");
                                    }
                                }
                            }
                        }
                    }
                    p=l;
                    if(autoplay==1 && p < 100){
                        setTimeout(function(){
                            colourGrid(data_grid,p+1);
                        }, 1000);

                    }
                }
                colourGrid(data_grid,0);

                $('#next').click(function () {
                    $("#play").prop('disabled', false);
                    autoplay=0;
                    colourGrid(data_grid,p+1);
                });

                $('#play').click(function () {
                    $("#play").prop('disabled', true);
                    autoplay=1;
                    colourGrid(data_grid,p);
                });

                $('#pause').click(function () {
                    $("#play").prop('disabled', false);
                    autoplay=0;
                    colourGrid(data_grid,p);
                });
            });


        </script>
        {{--@if(isset($game_data) && count($game_data) > 0)
            @if(isset($game_data[0]) && count($game_data[0]) > 0)
                @foreach($game_data[0] as $grid_row)
                    @if(isset($grid_row) && count($grid_row) > 0)
                        @foreach($grid_row as $grid_column)
                            @if($grid_column==1)

                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endif

        @if(isset($game_data) && count($game_data) > 0)
            @foreach($game_data as $game_dat)
                @if(count($game_dat) > 0)

                @endif
            @endforeach
        @endif--}}


    </body>
</html>
