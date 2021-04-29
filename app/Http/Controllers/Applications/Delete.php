<?php

namespace App\Http\Controllers\Applications;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Applications\Applications'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-applications'),'Denied'];
    }
}
