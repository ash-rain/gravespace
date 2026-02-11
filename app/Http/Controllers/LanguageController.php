<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected array $supportedLocales = ['en', 'fr', 'de', 'bg'];

    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, $this->supportedLocales)) {
            abort(400);
        }

        return redirect()->back()->cookie('locale', $locale, 60 * 24 * 365);
    }
}
