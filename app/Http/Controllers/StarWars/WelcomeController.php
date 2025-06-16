<?php

namespace App\Http\Controllers\StarWars;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
