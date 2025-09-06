<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserForm;

class CheckFormFilled
{
   public function handle(Request $request, Closure $next)
    {
        // Example: We check if this user already filled the form using email in session
        if (session()->has('email')) {
            $email = session('email');

            if (UserForm::where('email', $email)->exists()) {
                return response()->view('already-filled');
            }
        }

        return $next($request);
    }
}
