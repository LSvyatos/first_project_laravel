<?php

namespace App\Policies;

use App\Models\Users\Users;
use App\Models\Vacancy\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VacancyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any vacancies.
     *
     * @param  \App\Models\Users\Users  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the vacancy.
     *
     * @param  \App\Models\Users\Users  $user
     * @param  \App\Models\Vacancy\Vacancy  $vacancy
     * @return mixed
     */
    public function view(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can create vacancies.
     *
     * @param  \App\Models\Users\Users  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $priv=(new \App\Http\Controllers\Users\Privileges)->get();
             return true;
    }

    /**
     * Determine whether the user can update the vacancy.
     *
     * @param  \App\Models\Users\Users  $user
     * @param  \App\Models\Vacancy\Vacancy  $vacancy
     * @return mixed
     */
    public function update(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can delete the vacancy.
     *
     * @param  \App\Models\Users\Users  $user
     * @param  \App\Models\Vacancy\Vacancy  $vacancy
     * @return mixed
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can restore the vacancy.
     *
     * @param  \App\Models\Users\Users  $user
     * @param  \App\Models\Vacancy\Vacancy  $vacancy
     * @return mixed
     */
    public function restore(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vacancy.
     *
     * @param  \App\Models\Users\Users  $user
     * @param  \App\Models\Vacancy\Vacancy  $vacancy
     * @return mixed
     */
    public function forceDelete(User $user, Vacancy $vacancy)
    {
        //
    }
}
