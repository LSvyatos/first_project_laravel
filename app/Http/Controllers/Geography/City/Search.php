<?php

namespace App\Http\Controllers\Geography\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\Geography\City","\Geography\City\Get"];
   protected $paramsSortColumn=["id","type","name"];
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
   $query->where('name',$this->word)
         ->orWhere('name','like','%'.$this->word.'%')
         ->orWhere('nameUA','like','%'.$this->word.'%')
         ->orWhere('nameRU','like','%'.$this->word.'%')
         ->orWhere('namePL','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%')
         ->orWhereHas('country', function ($q)
          {
             $q->where('name', "like", "%".$this->word."%");
          })
         /*->orWhereHas('region', function ($q)
          {
             $q->where('name', "like", "%".$this->word."%");
          })*/;
  }

}
