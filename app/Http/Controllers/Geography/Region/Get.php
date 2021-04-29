<?php

namespace App\Http\Controllers\Geography\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionGet;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;

class Get extends ActionGet
{
    protected $model=["\Geography\Region"];
    //
    public function go($id)
    {
     $this->setId([$id]);
     return $this->get();
    }
    protected function inFor(&$arr)
    {
      if(isset($arr->countryID))
      {
       $arr->country;
      }
    }
}
