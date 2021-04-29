<?php

namespace App\Http\Controllers\Geography\Region;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Geography\Region","\Geography\Region\Search"];

   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy')];
   }
}
