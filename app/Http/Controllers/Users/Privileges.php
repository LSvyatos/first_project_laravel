<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\UsersPrivileges;
use App\Http\Controllers\Controller;

class Privileges extends Controller
{
 public function get()
 {
  return Auth::user()["role"];
  $get=UsersPrivileges::select('privilege')->where('user',$id)->get();
  if(count($get)>0)
  {
   return $get[0]->privilege;
  }
  return 0;
 }
}
?>
