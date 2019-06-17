<!DOCTYPE html>
<html>
<head>


    <title>Special Monitoring</title>

    <link href="{{asset('css/application.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/header_tt.css')}}">
    <script type="text/javascript" src="{{asset('js/header_tt.js')}}"></script>
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    

    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
                      */
                      var tempNotifiCount = 0;

                  </script>
                  <style type="text/css">
                  #notification_box{
                    z-index: 100000000000000 !important;
                }
                #support-menu{
                    z-index: 1000000000000 !important;
                }
                .wrap{
                    margin-left:-2%;
                }
                .sidebar{
                    position:relative;
                }
            </style>

        </head>

        <!-- <script src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script> -->

        <!-- <script src="{{asset('lib/widgster/widgster.js')}}"></script> -->
        <script src="{{asset('lib/underscore/underscore.js')}}"></script>

        <!-- common application js -->
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/settings.js')}}"></script>
        <link href="{{asset('css/read_only.css')}}" rel="stylesheet">


        <body>


            
            <div>                
                <br>
                <br>
                <br>
                <div class="col-md-8 col-md-offset-2 col-sm-3">
                    <center>
                    <h2>Priority Link/Site Dashboard</h2>
                    </center>
                </div>
                <div class="col-md-8 col-md-offset-2 col-sm-3" >
                    <center>
                    <a href="{{ url('/') }}" class="fa fa-home" style="margin: 5px; color: red"></a>
                    </center>
                </div>
                <br>
                <br>
                <br>
                <div class="col-md-8 col-md-offset-2 col-sm-3">
                    <a href="{{ url('priority_link_down') }}">
                        <div class="panel panel-danger">                                     
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-xs-1">
                                    </div>
                                    <div class="col-xs-3">
                                        <br>
                                        <i class="fa fa-link fa-5x"></i>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <h3><b>{{$link_down_lists[0]->link_faults}}</b></h3>
                                        <h4><b>Priority Link Down</b></h4><br>
                                    </div>
                                    <div class="col-xs-1">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </a>
                </div>
                


             
                <div class="col-md-8 col-md-offset-2 col-sm-3">
                    <a href="{{ url('priority_site_down') }}">
                        <div class="panel panel-warning">                                     
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-xs-1">
                                    </div>
                                    <div class="col-xs-3">
                                        <br>
                                        <i class="fa fa-sitemap fa-5x"></i>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <h3><b>{{$site_down_lists[0]->site_faults}}</b></h3>
                                        <h4><b>Priority Site Down</b></h4><br>
                                    </div>
                                    <div class="col-xs-1">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </a>
                </div>





                <div class="col-md-8 col-md-offset-2 col-sm-3">
                    <a href="{{ url('priority_link_other') }}">
                        <div class="panel panel-danger-alarm">                                     
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-xs-1">
                                    </div>
                                    <div class="col-xs-3">
                                        <br>
                                        <i class="fa fa-link fa-5x"></i>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <h3><b>{{$link_other_lists[0]->link_faults}}</b></h3>
                                        <h4><b>Priority Link Other Issues</b></h4><br>
                                    </div>
                                    <div class="col-xs-1">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </a>
                </div>
                


             
                <div class="col-md-8 col-md-offset-2 col-sm-3">
                    <a href="{{ url('priority_site_other') }}">
                        <div class="panel panel-warning-alarm">                                     
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-xs-1">
                                    </div>
                                    <div class="col-xs-3">
                                        <br>
                                        <i class="fa fa-sitemap fa-5x"></i>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <h3><b>{{$site_other_lists[0]->site_faults}}</b></h3>
                                        <h4><b>Priority Site Other Issues</b></h4><br>
                                    </div>
                                    <div class="col-xs-1">
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </a>
                </div>


            </div>




        </body>
        </html>

