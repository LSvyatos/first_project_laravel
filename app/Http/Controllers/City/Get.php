<?php

namespace App\Http\Controllers\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionGet;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;

class Get extends ActionGet
{
    protected $model=["\City"];
    //
    public function go($id)
    {
     $this->setId([$id]);
     return $this->get();
    }
}
