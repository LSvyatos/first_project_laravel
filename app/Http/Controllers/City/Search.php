<?php

namespace App\Http\Controllers\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\City","\City\Get"];
   public function go(Request $request)
   {
    if(count($request->all())>0)
    {
     $params=$request->all();
    }else{
     $params=[];
    }
    $params["numberPage"]=1000;
    self::setParams($params);
    return self::get();
   }
}
