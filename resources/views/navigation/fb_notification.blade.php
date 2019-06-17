
<a  href="#"  class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-globe"></i>
                            <span class="count" id="count_value" style="background:red;font-weight:bold;">0</span>
                        </a>


<ul id="support-menu" class="dropdown-menu support" role="menu" style="color:black !important;">
    
</ul>
<div id = "dialogMsg" title = "" style="font-size:20px;">
            <p> </p>
         </div>
<!-- <script   src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
      <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
      <script src="{{asset('js/jquery-ui.js')}}"></script>
<style>
  p {
    
   span {
    background: black;
    padding: 1px 8px;
    display:none;
    &::test {
      content: "\A";
    }

      }

    }
    .ui-icon ui-icon-info{
      font-size:20px;
    }
  #exclamation{
    color:orange;
  }
  .ui-draggable .ui-dialog-titlebar{
    background-color:#3361b5;
  }
</style>      
<script>
var tempVal = document.getElementById('hiddenNotificationCount').value;
var lists = '';
var lis;
var count=0;
var newNotification;
var isShow='false';
var dataList = new Array();
var notificationString = '';

// $.get("NotificationList").done(function( data ) {
//     var lis = JSON.parse(data);
//     var temp = 0;
//     //alert(isShow);
//     for (var key in lis[0]) {
//         if (lis[0].hasOwnProperty(key)) {
//           if(temp<10){
//                 lists += '<li role="presentation">';
//                 lists += '<a href=';
//                 lists += "{{url('EditTT')}}?ticket_id="+lis[0][key]['ticket_id'];
//                 lists += " class='support-ticket' >";
//                 lists += '<div class="picture"><span class="label label-important">#'+lis[0][key]['ticket_id']+'</span></div><div class="details">'+lis[0][key]['notification_string']+'</div></a></li>';
//                 newNotification = lis[0][key]['ticket_id']+'  ';
//                 // if(tempNotifiCount != 0){
//                 //   if(tempNotifiCount < currentVal){
//                 //   }
//                 // }
//           }
//           temp++;      
//           count++;
//         }
//       }
//       lists += '<li role="presentation">' ;
//       lists += "<a href={{url('NotificationView')}}";
//       lists += ' class="text-align-center see-all"> See all notifications <i class="fa fa-arrow-right"></i></a></li>';

//         //alert(document.getElementById('hiddenNotificationCount').value );
        
//       document.getElementById('count_value').innerHTML = count;
//       var currentVal = document.getElementById('count_value').innerHTML;
//       // $('#dialogMsg').dialog({
//       //               closeText : ''
//       //           });
//       //       $("#dialogMsg").text("your text here");
//       // if(tempVal !='' && tempVal != count){
        
//         //alert('tempNotifiCount = '+tempNotifiCount);
//         //alert('currentVal' + currentVal);
//       // }
//       //alert(tempNotifiCount);

//           // alert('count = '+count);
//           // alert('tempNotifiCount = '+tempNotifiCount);
//           // $('#dialogMsg').dialog({
//           //             closeText : '',
//           //             width: 500,
//           //             height: 100,
//           //             modal: true
//           //         });
//           //   $("#dialogMsg p").text(newNotification);
        
//         // $.get("NotificationAlert").done(function( isShowAlerts ) {
//           //alert(datas);
//           // var isShowAlert = isShowAlerts;
//           // if(isShowAlert == 'true'){
//             // $.getScript("js/jquery-1.10.2.js", function(){  
//             //   $( document ).ready(function() {
//                 //alert($("#dialogMsg p").text());
//                 //var isShow = 'false';
                   

                

//             //     });
//             // });
//           // }
         
//         // });
      
//           // alert('tempNotifiCount = '+tempNotifiCount);
//           //alert('count = '+count);
            
            

          
//       //   }
//       // }
//       // setInterval(function(){
//       // if(tempNotifiCount != 0){
//         document.getElementById('hiddenNotificationCount').value = count; 
//         tempNotifiCount =  count;
//       // }
//       //alert('after increasing tempNotifiCount = '+tempNotifiCount);
//       // }, 3000);
      
//       //alert(document.getElementById('hiddenNotificationCount').value );

      
      

//     document.getElementById('support-menu').innerHTML = lists;
 
//   });
/**********************************Notification Alert*************************************************/

// setTimeout(function(){ 
// $.get("NotificationAlert").done(function( isShowAlerts ) {
//       dataList = isShowAlerts;
//       if(dataList.length > 0){
//         isShow = 'true';
//         for(var i=0;i<dataList.length;i++){
//             notificationString += (i+1)+'. (ticket_id : '+dataList[i]['ticket_id']+')['+dataList[i]['notification_creation_time']+'] '+dataList[i]['notification_string']+'<br>'; 
//         }
//         // alert(dataList[0]['notification_string']);
//       }
// }); 
// }, 2000); 
// //alert(isShow);
// setTimeout(function(){ 
// if(isShow == 'true'){
//     var d = new Date();
//     var n = d.getMinutes();
//     if(n%5 ==0){
//       $('#dialogMsg').dialog({
//                             closeText : '',
//                             width: 800,
//                             modal: true,
//                             closeOnEscape: true,
//                             position: { my: 'top', at: 'top+150' }
//                         });
//       //notificationString = notificationString.replace(/['"]+/g, '')
//       //alert(notificationString);
//       $("#dialogMsg p").html(notificationString);
//       $('.ui-dialog-title').html('<span class="fa fa-exclamation-triangle fa-3x" id="exclamation"></span>');
//       //$("#dialogMsg p").text(notificationString.replace('<span>test</span>',''));
//     }
    
// }
// }, 3000);  



/*************************************************************************************************************/                
</script>
