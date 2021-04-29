<?php
namespace App\Http\Controllers\Vacancy\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;

class Edit extends ActionEdit
{
  protected $model=["\Vacancy\VacancyClients"];

  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-vacancy-clients',Get::getAuthor($id)["id"]))
    {
     return [0];
    }
  }
}
?>
