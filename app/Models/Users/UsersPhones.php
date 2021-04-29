<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UsersPhones extends Model
{
    protected $table="users_phones";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
}
