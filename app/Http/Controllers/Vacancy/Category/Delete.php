<?php
namespace App\Http\Controllers\Vacancy\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;


class Delete extends ActionDelete
{
    protected $model=['\Vacancy\VacancyCategory'];
    protected function denies($id=0)
    {
     return [Gate::denies('delete-vacancy-category'),'Denied'];
    }
}
