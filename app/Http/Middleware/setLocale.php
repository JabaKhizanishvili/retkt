<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // If it's a POST request, continue without any changes
        if ($request->isMethod('post')) {
            return $next($request);
        }

        // Get the locale from the URL segment
        $locale = $request->segment(1);

        // Get the default locale from config
        $defaultLocale = config('app.locale');
        URL::defaults(['locale' => $locale]);


        // Set the application locale
        if (strlen($locale) == 2) {
            app()->setLocale($locale);
        } else {
            // If the locale is not in the URL, redirect with default locale
            return $this->redirectToDefaultLocale($request);
        }

        // Share the current locale with Inertia
        Inertia::share("locale", app()->currentLocale());

        // Get and share translations with Inertia
        $this->shareTranslations($locale);

        return $next($request);
    }

    protected function shareTranslations($locale)
    {
        // Fetch translations from cache or generate them if not cached
        $translations = Cache::remember('translations', now()->addHours(24), function () {
            $translations = [];

            // Loop through language directories
            foreach (scandir(base_path('lang')) as $langDirectory) {
                if ($langDirectory !== '.' && $langDirectory !== '..' && is_dir(base_path('lang') . '/' . $langDirectory)) {
                    // Initialize translations for the language
                    $translations[$langDirectory] = [];

                    // Loop through files in each language directory
                    foreach (scandir(base_path('lang') . '/' . $langDirectory) as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                            $translationKey = pathinfo($file, PATHINFO_FILENAME);
                            $translations[$langDirectory][$translationKey] = json_decode(file_get_contents(base_path('lang') . '/' . $langDirectory . '/' . $file), true);
                        }
                    }
                }
            }

            return $translations;
        });

        // Share translations for the current locale with Inertia
        Inertia::share("translations", $translations[$locale]);
    }

    protected function redirectToDefaultLocale(Request $request)
    {
        $segments = $request->segments();
        array_unshift($segments, config('app.locale'));
        return redirect()->to(implode('/', $segments));
    }
}