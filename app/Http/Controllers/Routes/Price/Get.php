<?php

namespace App\Http\Controllers\Routes\Price;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Routes\RoutePrice'];

    protected $key="route";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-routes-price');
     return [$gate];
    }
}
