<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TransportAbout extends Model
{
    protected $table="transport_about";
    static public $data=array(
      "id"=>"id",
      "transport"=>"transport",
      "text"=>"text",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
     "transport"=>[1,6,6],
     "text"=>[1,6,6]
    );
    static public $validationCreate=[
     'transport'=>['required'],
     'text'=>['required']
    ];
}
