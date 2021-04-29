<?php

namespace App\Policies\Vacancy;

use App\Models\Vacancy\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function view($user,Vacancy $v)
    {
        return true;
    }
}