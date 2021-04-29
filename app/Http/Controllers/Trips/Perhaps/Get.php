<?php

namespace App\Http\Controllers\Trips\Perhaps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Trips\TripsPerhaps'];
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-trips-perhaps');
     return [$gate];
    }
}
