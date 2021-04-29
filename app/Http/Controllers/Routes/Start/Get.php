<?php

namespace App\Http\Controllers\Routes\Start;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Routes\RouteStart'];

    protected function denies($id=0)
    {
     $gate=Gate::denies('get-routes-start');
     return [$gate];
    }
}
