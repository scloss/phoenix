@include('navigation.p_header')
<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.css">
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    //     $('#ticket_table_view').DataTable( {
    //     initComplete: function () {
    //         this.api().columns().every( function () {
    //             var column = this;
    //             var select = $('<select><option value=""></option></select>')
    //                 .appendTo( $(column.footer()).empty() )
    //                 .on( 'change', function () {
    //                     var val = $.fn.dataTable.util.escapeRegex(
    //                         $(this).val()
    //                     );
 
    //                     column
    //                         .search( val ? '^'+val+'$' : '', true, false )
    //                         .draw();
    //                 } );
 
    //             column.data().unique().sort().each( function ( d, j ) {
    //                 select.append( '<option value="'+d+'">'+d+'</option>' )
    //             } );
    //         } );
    //     }
    // } );
    var table = $('#ticket_table_view').DataTable({
        searchPane: true,
        sort:false
    });
    $('.pane').each(function(i, obj) {
        //console.log(i);
        // if(i == 0 ){
        //     $(obj).hide();
        // }
        
    });

});
</script>
<style type="text/css">
    div.dt-searchPanes div.pane div.title{
        background-color: transparent !important;
    }
</style>
<div class="content container">
    <h2 class="page-title">OP List<span class="fw-semi-bold"></span></h2>  
	<div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="body">
                  
                        <table class="table table-striped" id="ticket_table_view">
                            <thead>
                            <tr>
                                <th class="hidden-xs">Ticket ID</th>
                                <th class="hidden-xs">Ticket Title</th>
                                <th class="hidden-xs">Client</th>
                                <th class="hidden-xs">Link Type</th>
                                <th class="hidden-xs">OP Comment</th>
                                <th class="hidden-xs">Task Comment Time</th>
                                <th class="hidden-xs">Issue Type</th>
                                <th class="hidden-xs">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($op_lists as $op_list)
                                    <tr id="myDiv">
                                        <td class="hidden-xs">{{$op_list->ticket_id}}</td>
                                        <td class="hidden-xs">{{$op_list->ticket_title}}</td>
                                        <td class="hidden-xs">{{$op_list->client}}</td>
                                        <td class="hidden-xs">{{$op_list->link_type}}</td>
                                        
                                        <td class="hidden-xs">
                                            {{$op_list->task_comments}}
                                        </td>
                                    
                                        <td class="hidden-xs">
                                            {{$op_list->task_comment_time}}
                                        </td>
                                        <td class="hidden-xs">
                                            {{$op_list->issue_type}}
                                        </td>
                                        <td>
                                        	<a href="{{ url('EditTT')}}?ticket_id={{$op_list->ticket_id}}" id="edit_button" style="color:#fff;font-size:1.3em"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">

                        </div>
                    </div>
                </section>
            </div>

        </div>
</div>
@include('navigation.p_footer')