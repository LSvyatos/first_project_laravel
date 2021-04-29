<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table="city";
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "country"=>"country",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,false,0,6],
     "country"=>[1,false,0,6]
    );
}
