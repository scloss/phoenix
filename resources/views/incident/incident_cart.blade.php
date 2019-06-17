<script type="text/javascript">
    
    document.getElementById('incident-collapse').className = 'panel-collapse collapse in';
    document.getElementById('incident_merge').className = 'active';
</script>

<div class="col-md-3"></div>
<div id="incident_box_merge" class="col-md-6">
    <section class="widget">
        <header>
            <center>
                <h4></h4>
            </center>
        </header>
        <div class="body">
        	@if(isset($_SESSION["CURRENT_LIST"]))
                <?php 
                $incident_list_arr = explode(',',$_SESSION["CURRENT_LIST"]);
                ?>
            <table id="incident_cart_table_merge">
                <tr>
                    <th>ID</th><th>Incident Title</th><th></th>
                </tr>
                @if(isset($_SESSION["CURRENT_LIST"]))
                    @for($i=0;$i<count($incident_list_arr);$i++)
                        <?php
                            $single_incident_arr = explode('|', $incident_list_arr[$i]);
                            $tempVar='';
                        ?>
                        <tr>
                        @for($j=0;$j<count($single_incident_arr);$j++)
                            <td><a href="{{url('IncidentViewSingle')}}?incident_id={{$single_incident_arr[0]}}">{{$single_incident_arr[$j]}}</a></td>
                            <?php 
                                $tempVar .= $single_incident_arr[$j].'|';
                            ?>              
                        @endfor
                        <?php 
                            $tempVar = trim($tempVar,'|');  
                        ?>
                        <td><a href="#" id="{{$tempVar}}" onclick="incident_delete(this.id)"><span class="glyphicon glyphicon-remove-sign"></a></span></td>
                        </tr>
                    @endfor
                @endif
                <form method="post" action="{{url('IncidentMergeProcess')}}">
                    <tr>
                        <th colspan="3"><b>Provide New Incident Title</b></th>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" placeholder="New Incident Title" required></td>
                    </tr>
                    <tr>
                        <th colspan="3"><b>Provide New Incident Location</b></th>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="text" id="incident_location" name="incident_location" class="form-control input-transparent" placeholder="New Incident Location" required></td>
                    </tr>
                    <tr>
                        <th colspan="3"><b>Provide New Incident Description</b></th>
                    </tr>
                    <tr>
                        <td colspan="3"><textarea id="incident_description" name="incident_description" class="form-control input-transparent" required></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="Merge Now" value="Merge Now" class="btn btn-primary" style="font-size:17px;"></td>
                    </tr>
                </form>
            </table>
            
            @endif
        </div>
    </section>
</div>
<div class="col-md-3"></div>