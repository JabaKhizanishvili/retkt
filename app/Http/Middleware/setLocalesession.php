<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class setLocalesession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         app()->setLocale(config('app.locale'));
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        // dd(app()->currentLocale(),session('locale') );
        Inertia::share("locale", app()->currentLocale());

        $this->shareTranslations(app()->currentLocale());

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
}
