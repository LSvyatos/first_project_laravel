<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportPerhaps extends Model
{
    protected $table="transport_perhaps";
    static public $data=array(
      "id"=>"id",
      "transport"=>"transport",
      "place"=>"place",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
     "transport"=>[1,6,6],
     "place"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'transport'=>['required'],
     'place'=>['required']
    ];
}
