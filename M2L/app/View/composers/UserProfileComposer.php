<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserProfileComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $loggedInUser = Auth::user();
            $view->with('loggedInUser', $loggedInUser);
        } else {
            $view->with('loggedInUser', null); // Ou toute autre valeur par défaut
        }
    }
}