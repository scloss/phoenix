<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentModel extends Model
{
    protected $table = 'phoenix_tt_db.incident_table';
    public $timestamps = false;
}
