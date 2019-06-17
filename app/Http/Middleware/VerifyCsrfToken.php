<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    // protected $except = [
    //     //
    // ];
    public function handle($request, Closure $next)
	{
		//return parent::handle($request, $next);
		$skip = array(
					'IncidentCartInsert',
					'IncidentCartDelete',
					'CreateTicket',
					'EditTicket',
					'IncidentMergeProcess',
					'authenticate',
					'AddResolution',
					'DeleteResolution',
					'ExportReport',
					'insert_client',
					'delete_client',
					'update_client',
					'insert_link',
					'delete_link',
					'update_link',
					'insert_site',
					'delete_site',
					'update_site',
					'LinkApi',
					'UnmsApi',
					'TaskView'
					);
 
		foreach ($skip as $key => $route) {
			//skip csrf check on route
			if($request->is($route)){
				return parent::addCookieToResponse($request, $next($request));
			}
		}
 
		return parent::handle($request, $next);
	}

}
