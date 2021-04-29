<?php

namespace App\Http\Controllers\Trips\Children;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Trips\TripsChildren'];

    protected $key="route";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-trips-children');
     return [$gate];
    }
}
