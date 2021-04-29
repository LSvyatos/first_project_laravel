<?php

namespace App\Http\Controllers\Trips\Perhaps;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Trips\TripsPerhaps","\Trips\Perhaps\Get"];

  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-trips');
  }
  protected function word(&$query)
  {
   $query->where('perhap','like','%'.$this->word.'%');
  }
}
