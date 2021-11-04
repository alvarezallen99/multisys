<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     *  redirected to when they are not authenticated.
     *
     */
    protected function redirectTo($request)
    {
        return abort(403);
    }
}
