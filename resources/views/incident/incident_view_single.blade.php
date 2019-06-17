@include('navigation.p_header')
<style type="text/css">
	#incident_ticket_table{
		width:60%;
		margin-left:20%;
	}
	#incident_ticket_table td{
		border:1px solid grey;
		text-align:center;
		padding:2%;
	}
	.widget{
		width:80%;
		margin-left:10%;
		margin-top:2%;
	}

</style>
<section class="widget">
        <header>
            <center>
                <h4></h4>
            </center>
        </header>
        <div class="body">
        	<table id="incident_ticket_table">
        	<tr><td colspan="3">Incident ID</td></tr>
        	<tr><td colspan="3">{{$incident_id}}</td></tr>
        	<tr>
        		<td>Ticket ID</td><td>Ticket Title</td><td>Ticket Assigned Dept</td>
        	</tr>
        	@foreach($ticket_lists as $ticket_list)
        		<tr>
	        		<td>{{$ticket_list->ticket_id}}</td>
	        		<td>{{$ticket_list->ticket_title}}</td>
	        		<td>{{$ticket_list->assigned_dept}}</td>
        		</tr>
        	@endforeach
        	</table>
        </div>
</section>        
@include('navigation.p_footer')