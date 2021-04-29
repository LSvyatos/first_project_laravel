<?php

namespace App\Http\Controllers\Transports\About;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Transport\TransportAbout'];

    protected $key="route";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-transport-about');
     return [$gate];
    }
}
