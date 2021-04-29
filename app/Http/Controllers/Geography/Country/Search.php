<?php

namespace App\Http\Controllers\Geography\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\Geography\Country","\Geography\Country\Get"];
   protected $paramsSortColumn=["id","name"];
   public function go(Request $request)
   {
    if(count($request->all())>0)
    {
     $params=$request->all();
    }else{
     $params=[];
    }
    self::setParams($params);
    return self::get();
   }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
          ->orWhere('id','like','%'.$this->word.'%');
  }
}
