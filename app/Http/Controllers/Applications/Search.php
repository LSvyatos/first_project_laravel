<?php

namespace App\Http\Controllers\Applications;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Applications\Applications","\Applications\Get"];


  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-applications');
  }
  protected function word(&$query)
  {
   //$query->where('id','like','%'.$this->word.'%');
  }
}
