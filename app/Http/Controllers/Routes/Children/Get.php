<?php

namespace App\Http\Controllers\Routes\Children;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Routes\RouteChildren'];
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-routes');
     return [$gate];
    }
    protected function inFor(&$arr)
    {
    if(isset($arr->fromID))
    {
     $arr->from;
    }
    if(isset($arr->toID))
    {
     $arr->to;
    }
    if(isset($arr->routeID))
    {
     $arr->route;
    }
     $arr->timeFrom=$arr->timeFrom()->first()["time"];
    }
}
