<?php

namespace App\Http\Controllers\Routes\Children;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Routes\RouteChildren","\Routes\Children\Get"];

  public function go(Request $request)
  {
   self::setParams($request->all());

   $res=self::get();
   return $res;
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-routes');
  }
  protected function word(&$query)
  {
   $query->where('priceUAN','like','%'.$this->word.'%')
         ->orWhere('pricePLN','like','%'.$this->word.'%')
         ->orWhere('priceUSD','like','%'.$this->word.'%')
         ->orWhere('priceEUR','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%')
         ->orWhere('text','like','%'.$this->word.'%')
         ->orWhereHas('from', function ($q)
            {
               $q->where('name', "like", "%".$this->word."%")
                 ->orWhere('nameUA', "like", "%".$this->word."%")
                 ->orWhere('namePL', "like", "%".$this->word."%")
                 ->orWhere('nameRU', "like", "%".$this->word."%");
            })
         ->orWhereHas('to', function ($q)
            {
               $q->where('name', "like", "%".$this->word."%")
                 ->orWhere('nameUA', "like", "%".$this->word."%")
                 ->orWhere('nameRU', "like", "%".$this->word."%")
                 ->orWhere('namePL', "like", "%".$this->word."%");
            });
  }
}
