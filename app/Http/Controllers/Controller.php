<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /*
    
    select i.*,t.*,f.* from incident_table as i, ticket_table as t, fault_table as f
where f.element_id in (select link_table.link_name_id from link_table where link_table.link_name like '%NSPLS02%')
and f.ticket_id = t.ticket_id
and t.incident_id = i.incident_id
and t.ticket_title like '%we%'

*/
}
