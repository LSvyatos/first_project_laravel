<?php

namespace App\Http\Controllers\Clients\Messenger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Clients\ClientsMessenger'];

    protected $key="client";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-clients-messenger');
     return [$gate];
    }
}

