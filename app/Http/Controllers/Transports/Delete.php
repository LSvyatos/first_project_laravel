<?php

namespace App\Http\Controllers\Transports;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Transport\Transport'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-transport'),'Denied'];
    }
}
