<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AboutUsController extends Controller
{
    public function index()
    {
        return Inertia::render('AboutUs'); // This will render the AboutUs.vue component
    }
}