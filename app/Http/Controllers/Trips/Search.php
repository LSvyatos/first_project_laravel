<?php

namespace App\Http\Controllers\Trips;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Trips\Trips","\Trips\Get"];

  
  protected function beforeGet(&$arr,&$result)
  {
   if(array_key_exists("activeTime",$arr)&&$arr["activeTime"]==1)
   {
    $result->whereDate($this->models[0]::$data["timeFrom"],">=",date('Y-m-d'));
   }
  }
  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function word(&$query)
  {
   $query->where('id','like','%'.$this->word.'%')
         ->orWhere('text','like','%'.$this->word.'%')
         ->orWhere('timeFrom','like','%'.$this->word.'%')
         ->orWhereHas('from', function ($q)
                   {
                      $q->where('name', "like", "%".$this->word."%");
                   })
         ->orWhereHas('to', function ($q)
                   {
                      $q->where('name', "like", "%".$this->word."%");
                   })
         ->orWhereHas('transport', function ($q)
                   {
                      $q->where('name', "like", "%".$this->word."%")
                        ->orWhere('number', "like", "%".$this->word."%");
                   })
         ->orWhereHas('steward', function ($q)
                   {
                      $q->where('name', "like", "%".$this->word."%")
                        ->orWhere('lastname', "like", "%".$this->word."%");
                   });
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-trips');
  }
}
