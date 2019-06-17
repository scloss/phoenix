@include('navigation.p_header')

<script src="{{asset('copy_html/index.js')}}"></script>

<style type="text/css">
    td{
        background:#2980b9;
        border:2px solid white;

    }
    .emailTable,td{
        border:2px solid white; 
    }

    tr{
        border:2px solid white; 
    }
    
    td{
        border:2px solid white;
    }
   
</style>
        <section class="widget">
            <span class="code half">
            <div class="body no-margin" >
            <div>
            @for($i=0;$i<count($ticketArr);$i++)

                 <div class="row">

                        
                        <div class="col-sm-12 col-print-12" >
                            <table class="table table-bordered table-striped" id="header_position">
                                
                            </table>
                            
                        </div>
                        
                        <div class="col-sm-6 col-print-6" id="mail_text">
                            
                            <br>
                            <table class="table table-bordered table-striped emailTable" style="background-color:#2980b9" width="700">
                                <tr>
                                    <td colspan="2" style="border:2px solid white">
                                        @if($ticketArr[$i]['clear_time']!="")  
                                        <p> Dear Concern,</p>
                                        <pre style="background-color:#2980b9;border: 2px solid #2980b9">SCL Network Operation Center would like to provide you the Trouble ticket closing form : 
                                                                            </pre>
                                        @else
                                        <p> Dear Concern,</p>
                                        <p>SCL Network Operation Center would like to inform you that you have reported a fault(s). We have raised a trouble ticket against the notification, details as per below:</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:2px solid white">Ticket ID  </td>
                                    <td style="border:2px solid white">{{$ticketId}}</td>
                                </tr>
                                <tr>
                                    <td style="border:2px solid white">Fault ID  </td>
                                    <td style="border:2px solid white">{{trim($ticketArr[$i]['fault_id'],',')}}</td>
                                </tr>
                                <tr>
                                    <td style="border:2px solid white">Status  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['status']}}
                                    </td>
                                </tr>   
                                <tr>
                                    <td style="border:2px solid white">Problem Category  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['problem_category']}}
                                    </td>
                                </tr>                               
                                <tr>    
                                    <td style="border:2px solid white">Client ID  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['client']}}
                                    </td>
                                </tr>   
                                <tr>    
                                    <td style="border:2px solid white">Element Type  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['element_type']}}
                                    </td>
                                </tr>   
                                <tr>    
                                    <td style="border:2px solid white">Link Name  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['link_name']}}
                                    </td>
                                </tr>
                                <tr>    
                                    <td style="border:2px solid white">Link ID  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['link_id']}}
                                    </td>
                                </tr>
                                <tr>    
                                    <td style="border:2px solid white">Site Name  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['site_name']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:2px solid white">Impact  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['client_side_impact']}}
                                    </td>
                                </tr>                               
                                <tr>    
                                    <td style="border:2px solid white">Event Time  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['event_time']}}
                                    </td>
                                </tr>
                                @if($ticketArr[$i]['clear_time']!="")
                                <tr>    
                                    <td style="border:2px solid white">Clear Time  </td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['clear_time']}}
                                    </td>
                                </tr>
                                @endif


                                <tr>    
                                    <td style="border:2px solid white">Duration</td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['duration']}}
                                    </td>
                                </tr>

                                <tr>    
                                    <td style="border:2px solid white">Reason</td>
                                    <td style="border:2px solid white">
                                        {{$ticketArr[$i]['reason']}}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan="2" style="border:2px solid white">
                                        @if($ticketArr[$i]['clear_time']!="")  
                                        <p> 
                                        
                                        Thanking you for your professional cooperation and patience.
                                        </p> 
                                        
                                        @else
                                            @if($ticketArr[$i]['issue_type'] == 'ITC' || $ticketArr[$i]['issue_type'] == 'IIG')
                                            <p>
                                            Any update will be communicated whenever we will get. We are available 24x7 to assist you, please feel free to contact us ‎IIG/ITC: ‎01755650448/01755650449. Thanking you for your professional cooperation.</p>
                                            @elseif( $ticketArr[$i]['issue_type'] == 'ICX')
                                            <p>
                                            Any update will be communicated whenever we will get. We are available 24x7 to assist you, please feel free to contact us ‎ ICX: ‎01750220000. Thanking you for your professional cooperation.</p>
                                            @else
                                            <p>
                                            Any update will be communicated whenever we will get. We are available 24x7 to assist you, please feel free to contact us ‎01938432480 or ‎01938432481. Thanking you for your professional cooperation.</p>
                                            @endif

                                        
                                        @endif
                                    </td>
                                </tr>                           
                            </table>
                            
                        </div>
                   
                      </div>   
            @endfor
            <br>
            <br>
            </div>
            </div>
            </span>
             
                
            
            <div>
            <button class="btn btn-primary" onclick="copy()"><svg fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg></button>
            </div>
        </section>

        <script>
            function copy(){
                var markupContainer =document.getElementById("mail_text");// document.querySelector('#basic-html + span');
                console.log(markupContainer.innerHTML);
                copyToClipboard(markupContainer.innerHTML, {asHtml: true});
            }

            // (function() {
            // var markupContainer = document.querySelector('#basic-html + span');
            // document.querySelector('#basic-html ~ .half button')
            //     .addEventListener('click', function () {
            //     console.log(markupContainer.innerHTML);
            //     copyToClipboard(markupContainer.innerHTML, {asHtml: true})
            //     })
            // })();

            </script>

        
@include('navigation.p_footer')