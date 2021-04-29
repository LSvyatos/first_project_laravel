<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class Response extends Controller
{
    //
    static public function get($status,$number=0,$value=[],$params=[])
    {
     $res=[
             "status"=>$status,
             "number"=>$number,
             "value"=>$value
      ];
      if(!is_array($params))
      {
       $res["params"]=$params;
      }else if(count($params)>0)
      {
       $res["params"]=$params;
      }
      
      return $res;
    }
}
