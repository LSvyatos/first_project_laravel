<?php

namespace App\Http\Controllers\Geography\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;

class Delete extends ActionDelete
{
    //
    protected $model=['\Geography\Country'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-clients')];
    }
}
