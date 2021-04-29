<?php

namespace App\Http\Controllers\Clients\Phones;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;

class Delete extends ActionDelete
{
    //
    protected $model=['\Clients\ClientsPhones'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-clients')];
    }
}
