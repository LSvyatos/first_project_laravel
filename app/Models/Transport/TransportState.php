<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportState extends Model
{
    protected $table="transport_state";
    static public $data=array(
      "id"=>"id",
      "transport"=>"transport",
      "speedometer"=>"speedometer",
      "oilLevel"=>"oil_level",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
     "transport"=>[1,6,6],
     "speedometer"=>[1,6,6],
     "oilLevel"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'transport'=>['required'],
     'speedometer'=>['required'],
     'oilLevel'=>['required']
    ];

}
