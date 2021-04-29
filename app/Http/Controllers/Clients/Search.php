<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\Clients\Clients","\Clients\Get"];
   protected $paramsSortColumn=["id","name","lastname","surname"];
   public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-vacancy');
  }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
         ->orWhere('lastname','like','%'.$this->word.'%')
         ->orWhere('surname','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%')
         ->orWhereHas('phones', function ($q)
                   {
                      $q->where('phone', "like", "%".$this->word."%")
                        ->orWhere('phoneFormat', "like", "%".$this->word."%");
                   })
         ->orWhereHas('messenger', function ($q)
                  {
                      $q->where('messenger', "like", "%".$this->word."%");
                  })
         ->orWhereHas('address', function ($q)
                  {
                      $q->where('name', "like", "%".$this->word."%");
                  });
  }
}
