<?php

namespace App\Http\Controllers\Trips;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Trips\Trips'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-trips',app('App\Http\Controllers\Vacancy\Get')::getAuthor($id)["id"]),'Denied'];
    }
}
