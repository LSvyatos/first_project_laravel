<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;

class TripsChildren extends Model
{
    protected $table="trips_children";
    static public $data=array(
      "id"=>"id",
      "route"=>"route",
      "trip"=>"trip",
      "from"=>"_from",
      "to"=>"_to",
      "fromTime"=>"_from_time",
      "toTime"=>"_to_time",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
       "route"=>[1,0,6],
       "trip"=>[1,0,6],
       "from"=>[1,0,6],
       "to"=>[1,0,6],
       "fromTime"=>[0,0,6],
       "toTime"=>[0,0,6]
    );
    static public $validationCreate=[
     'route'=>['required'],
     'trip'=>['required'],
     'from'=>['required'],
     'to'=>['required'],
     'fromTime'=>['required'],
     'toTime'=>['min:1']
    ];
}
