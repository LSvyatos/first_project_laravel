<?php
namespace App\Http\Controllers\Tickets;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionDelete;
use Illuminate\Support\Facades\Gate;

class Delete extends ActionDelete
{
    protected $model=['\Tickets\Tickets'];
    protected function after($id,&$arr)
    {
        $this->models[0]->find($id)->perhap()->update(['ticketID'=>0]);
     //\App\Models\Trips\TripsPerhaps::where('id',$arr['perhap'])->update(['ticketID'=>0]);
    }
    protected function denies($id=0)
    {
     return [Gate::denies('delete-tickets'),'Denied'];
    }
}
