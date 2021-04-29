<?php

namespace App\Http\Controllers\Routes\Price;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Routes\RoutePrice","\Routes\Price\Search"];

   //private $access=0;
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('create-routes')];
   }
}
