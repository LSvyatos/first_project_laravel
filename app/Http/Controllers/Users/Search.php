<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\Users\Users","\Users\Get"];

   protected $filter=["city"];

   protected $paramsSortColumn=["id","name","lastname","surname"];

   public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  public function drivers()
  {
   return self::get(["role"=>3]);
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-users');
  }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
         ->orWhere('lastname','like','%'.$this->word.'%')
         ->orWhere('surname','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%');
  }
  protected function filter(&$arr)
  {
    if(array_key_exists('city',$this->filterValue))
    {
      $arr->whereHas('address', function ($q)
      {
         $q->where('cityID', $this->filterValue["city"]);
      });
    }
  }
}
