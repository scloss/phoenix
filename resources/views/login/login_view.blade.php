<!-- light-blue - v3.3.0 - 2016-03-08 -->

<!DOCTYPE html>
<html>
<head>
    <title>SCL TIcketing Tool</title>

    
    <link href="css\application.min.css" rel="stylesheet">
    <link href="css\login.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="img\favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
        */
    </script>
</head>
<body class="login-body">

        


        <div>
        <center><h4><img src="{{asset('/img/SCL_logo.png')}}" height="90px"></h4></center>
        <center><h4><img src="{{asset('/img/phoenix3.png')}}" width="375px" height="60px"></h4></center>
        <center>
            <section class="widget login-widget">
                <header class="text-align-center">

                    <h4>Login to your account</h4>
                </header>
                <center>
                <div class="body">
                    <form class="no-margin" action="{{ url('authenticate') }}" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label for="email">Username</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input id="text" type="text" name="username" class="form-control input-lg input-transparent" placeholder="Your Username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" name="password" class="form-control input-lg input-transparent" placeholder="Your Password" required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-block btn-lg btn-danger">
                                <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                                <small>Sign In</small>
                            </button>
                            <div class="form-group">
                                <a href="http://103.15.245.78:8005/login_plugin/send_password_link.html">Forgot Password</a>
                            </div>

                        </div>
                    </form>
                </div>
            </center>
                <br>
            </section>
        </center>
        </div>
<!-- common libraries. required for every page-->
<script src="lib\jquery\dist\jquery.min.js"></script>
<script src="lib\jquery-pjax\jquery.pjax.js"></script>
<script src="lib\bootstrap-sass\assets\javascripts\bootstrap.min.js"></script>
<script src="lib\widgster\widgster.js"></script>
<script src="lib\underscore\underscore.js"></script>

<!-- common application js -->
<script src="js\app.js"></script>
<script src="js\settings.js"></script>


</body>
</html>