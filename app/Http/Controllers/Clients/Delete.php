<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;

class Delete extends ActionDelete
{
    //
    protected $model=['\Clients\Clients'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-clients')];
    }
}
