<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class Delete extends ActionDelete
{
    protected $model=['\Users\Users'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-users'),'Denied'];
    }
}
