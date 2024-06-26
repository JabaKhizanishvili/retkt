<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Illuminate\Support\Facades\URL;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            // 'locale' => App()->currentLocale(),
            'url' => $request->url(),
            'currentroute' => Route::currentRouteName(),
            'locale_urls' => $this->locale_urls(),


        ];
    }


        protected function locale_urls()
    {
        $locales = [
            'Georgian' => 'ge',
            'English' => 'en',
        ];

$routes = array_map(function ($val) {
    return $this->get_url($val);
}, $locales);

return $routes;

    }


   protected function get_url($lang): string
{

    $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    $uriSegments[1] = $lang;


    $uriSegments = implode('/', $uriSegments);
    return $host . $uriSegments;
}
}