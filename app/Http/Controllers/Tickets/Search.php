<?php

namespace App\Http\Controllers\Tickets;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
   protected $model=["\Tickets\Tickets","\Tickets\Get"];

   //protected $paramsSortColumn=["id","perhapID"];

   public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-tickets');
  }
  protected function word(&$query)
  {
   $query->where('id','like','%'.$this->word.'%')
         ->orWhere('text','like','%'.$this->word.'%')
         ->orWhere('price','like','%'.$this->word.'%')
         ->orWhere('uid','like','%'.$this->word.'%')
         ->orWhere('unical','like','%'.$this->word.'%')
         ->orWhere('timeFrom','like','%'.$this->word.'%')
         ->orWhereHas('transport',function($q)
         {
          $q->where('name','like','%'.$this->word.'%')
            ->orWhere('number','like','%'.$this->word.'%');
         })
         ->orWhereHas('client',function($q)
         {
          $q->where('name','like','%'.$this->word.'%')
            ->orWhere('lastname','like','%'.$this->word.'%')
            ->orWhere('surname','like','%'.$this->word.'%');
         });
  }
}
