<?php

namespace App\Http\Controllers\Clients\Phones;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Gate;

class Create extends ActionCreate
{
   protected $model=["\Clients\ClientsPhones","\Clients\Phones\Search"];

   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy')];
   }
}
