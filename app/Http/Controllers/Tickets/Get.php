<?php
namespace App\Http\Controllers\Tickets;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;
//use App\Models\Vacancy\Vacancy;


class Get extends ActionGet
{
  protected $model=["\Tickets\Tickets"];

  protected function denies($id)
  {
   return [Gate::denies('get-tickets')];
  }
  protected function inFor(&$arr)
  {
   if(isset($arr->tripID))
   {
     $arr["trip"]=$arr->getTrip()->first();
     $arr->drivers;
   }
   if(isset($arr->fromID))
   {
    $arr->from;
   }
   if(isset($arr->toID))
   {
    $arr->to;
   }
   if(isset($arr->transportID))
   {
    $arr->transport;
   }
   if(isset($arr->currencyID))
   {
    $arr->currency;
   }
   if(isset($arr->typePaymentID))
   {
    $arr->typePayment;
   }
   if(isset($arr->perhapID))
   {
     $arr->perhap;
   }
  } 
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
