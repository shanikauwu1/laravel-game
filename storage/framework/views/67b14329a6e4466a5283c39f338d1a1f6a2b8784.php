<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
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
                font-size: 84px;
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
    </head>
    <body>



        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(Auth::check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>">Login</a>
                        <a href="<?php echo e(url('/register')); ?>">Register</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    Game Of Life
                </div>

                <!-- Main content -->
                <section class="content">


                    <!-- place view details starts -->
                    <div class="box">
                    <?php echo Form::open(['method' => 'POST','class'=>""]); ?>


                    <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group" >
                                <?php echo Form::label('game_type','Game type *',array('class' => '')); ?>

                                <div class="">
                                    <?php echo Form::select('game_type',['1'=>"Random",'2'=>"Gosper Glider Gun"], '', array('class'=>'form-control')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <small><?php echo Form::label('req','* Required Fields',array('class' => 'col-md-3 control-label')); ?></small>
                                </div>
                            </div>

                        </div> <br/>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <?php echo Form::submit('Run',['class'=>'btn btn-success']); ?>

                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>

                </section>
                <!-- /.content -->
            </div>
        </div>
    </body>
</html>
