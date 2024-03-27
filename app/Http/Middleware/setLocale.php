<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class setLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post')) {
            return $next($request);
        }
        $locale = $request->segment(1);
        $segments = $request->segments();
        $defaultLocale = config('app.locale');
        URL::defaults(['locale' => $locale ?? $defaultLocale]);

            if (strlen($locale) == 2) {
                array_shift($segments);
                $defaultLocale = $locale;
            }else{
                array_unshift($segments, $defaultLocale);
                return $this->redirectTo($segments);
            }

        app()->setLocale($defaultLocale);
         Inertia::share("locale", app()->currentLocale());


         $langPath = base_path('/lang');

    if (!Cache::has('translations')) {
    $translations = [];

    // Loop through language directories
    foreach (scandir($langPath) as $langDirectory) {
        if ($langDirectory !== '.' && $langDirectory !== '..' && is_dir($langPath . '/' . $langDirectory)) {
            // Initialize translations for the language
            $translations[$langDirectory] = [];

            // Loop through files in each language directory
            foreach (scandir($langPath . '/' . $langDirectory) as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $translationKey = pathinfo($file, PATHINFO_FILENAME);
                    $translations[$langDirectory][$translationKey] = json_decode(file_get_contents($langPath . '/' . $langDirectory . '/' . $file), true);
                }
            }
        }
    }

    // Cache the translations for future use
    Cache::put('translations', $translations, now()->addHours(24)); // Adjust the cache duration as needed
} else {
    // Retrieve translations from cache
    $translations = Cache::get('translations');
}

        //  $translations = trans('*', [], $locale);

         Inertia::share("translations", $translations[$defaultLocale]);

        return $next($request);
    }

      protected function redirectTo(array $segments)
    {
        return redirect()->to(implode('/', $segments));
    }
}