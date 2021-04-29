<?php
namespace App\Http\Controllers\Routes;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Routes\Route'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-routes'),'Denied'];
    }
}
