<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clients\Clients;
use App\Models\Geography\Region;
use App\Models\Geography\City;
use App\Models\Routes\RouteChildren;

class base extends Controller
{
    public function go()
    {
     $arr=[];
     /*$city=Region::get();
     foreach($city as $value)
     {
      $value->name=trim($value->name);
      $value->save();
     }*/
    }
}
