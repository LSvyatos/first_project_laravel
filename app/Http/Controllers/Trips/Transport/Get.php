<?php

namespace App\Http\Controllers\Trips\Transport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Trips\TripsTransport'];

    protected $key="route";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-trips-transport');
     return [$gate];
    }
}
