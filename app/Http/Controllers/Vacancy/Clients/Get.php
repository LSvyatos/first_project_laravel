<?php

namespace App\Http\Controllers\Vacancy\Clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Vacancy\VacancyClients'];
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-vacancy-clients');
     return [$gate];
    }
    public function go($id)//Клас для виклику з роутера
      {
       $this->setId([$id]);
       //return self::getImages(1);
       return $this->get();
      }
}
