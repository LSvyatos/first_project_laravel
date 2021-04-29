<?php

namespace App\Http\Controllers\Transports;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
  protected $model=["\Transport\Transport"];
  protected function denies($id)
  {
   return [Gate::denies('get-transport')];
  }

  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
