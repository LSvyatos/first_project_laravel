<?php

namespace App\Http\Controllers\Clients\Phones;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
    protected $model=["\Clients\ClientsPhones","\Clients\Phones\Get"];
   public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-vacancy');
  }
}
