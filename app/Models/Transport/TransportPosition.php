<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportPosition extends Model
{
    protected $table="transport_position";
    static public $data=array(
      "id"=>"id",
      "transport"=>"transport",
      "height"=>"height",
      "length"=>"length",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
     "transport"=>[1,6,6],
     "height"=>[1,6,6],
     "length"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'transport'=>['required'],
     'height'=>['required'],
     'length'=>['required']
    ];
}
