<?php

namespace App\Http\Controllers\StarWars;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function welcome(): RedirectResponse|Response
    {
        if (Auth::check()) {
            return redirect()->route('search');
        }

        return Inertia::render('welcome');
    }
}
