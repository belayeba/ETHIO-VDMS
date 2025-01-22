<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setlocale($lang)
    {
        // Validate if the language is supported
        if (in_array($lang, ['en', 'am'])) {
            // Set the locale for the application
            App::setLocale($lang);

            // Store the selected locale in the session
            Session::put('locale', $lang);
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
}
