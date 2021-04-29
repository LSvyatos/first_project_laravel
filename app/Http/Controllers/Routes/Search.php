<?php

namespace App\Http\Controllers\Routes;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Routes\Route","\Routes\Get"];

  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-routes');
  }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
          ->orWhere('id','like','%'.$this->word.'%')
          ->orWhere('text','like','%'.$this->word.'%');
  }
}
