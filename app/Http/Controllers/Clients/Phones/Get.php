<?php

namespace App\Http\Controllers\Clients\Phones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Clients\ClientsPhones'];
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-clients-phones');
     return [$gate];
    }
}
