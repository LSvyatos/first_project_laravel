<?php

namespace App\Http\Controllers\Geography\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;

class Edit extends ActionEdit
{
  protected $model=["\Geography\Country"];

  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-country'))
    {
     return [0];
    }
  }
}
