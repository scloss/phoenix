@include('navigation.p_header')
<div class="content container">
    <h2 class="page-title">Notification List<span class="fw-semi-bold"></span></h2>  
	<div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="body">
                    <div class="pagination"> {!! str_replace('/?', '?', $notification_lists->appends(Input::except('page'))->render()) !!} </div>
                        <table class="table table-striped" id="ticket_table_view">
                            <thead>
                            <tr>
                                <th class="hidden-xs">Ticket ID</th>
                                <th class="hidden-xs">Status</th>
                                <th class="hidden-xs">Assigned Department</th>
                                <th class="hidden-xs">Notification</th>
                                <th class="hidden-xs">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notification_lists as $notification_list)
                                    <tr id="myDiv">
                                        <td class="hidden-xs">{{$notification_list->ticket_id}}</td>
                                        <td class="context-menu-one">
                                            {{$notification_list->status}}
                                        </td>
                                        <td class="hidden-xs">
                                            <?php $assigned_dept_arr = explode(',',$notification_list->assigned_dept) ;?>
                                            @for($i=0;$i<count($assigned_dept_arr);$i++)
                                                @foreach($department_lists as $department_list)
                                                    @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                        @if($i == count($assigned_dept_arr))
                                                            {{$department_list->dept_name}}</h5>
                                                        @else
                                                            {{$department_list->dept_name}},</h5>
                                                        @endif    
                                                    @endif

                                                @endforeach  
                                            @endfor
                                        </td>
                                        <td class="hidden-xs">

                                            {{$notification_list->notification_string}}
                                        </td>
                                        <td>
                                        	<a href="{{ url('EditTT')}}?ticket_id={{$notification_list->ticket_id}}" id="edit_button" style="color:#fff;font-size:1.3em"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
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