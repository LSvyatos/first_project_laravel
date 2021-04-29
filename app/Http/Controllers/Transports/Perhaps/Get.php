<?php

namespace App\Http\Controllers\Transports\Perhaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Transport\TransportPerhaps'];

    protected $key="route";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-transport-perhaps');
     return [$gate];
    }
}
