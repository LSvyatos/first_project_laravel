<?php

namespace App\Http\Controllers\Vacancy;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Vacancy\Vacancy'],
              $allow=['delete-vacancy'];
    protected function after($id,&$arr)
    {
     $this->models[0]::find($id)->image()->delete();
    }
    protected function denies($id=0)
    {
     return [Gate::denies('delete-vacancy',app('App\Http\Controllers\Vacancy\Get')::getAuthor($id)["id"]),'Denied'];
    }
}
