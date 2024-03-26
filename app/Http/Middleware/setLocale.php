<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

            if (strlen($locale) <= 2) {
                array_shift($segments);
                $defaultLocale = $locale;
            }else{
                array_unshift($segments, $defaultLocale);
                return $this->redirectTo($segments);
            }

        app()->setLocale($defaultLocale);

        return $next($request);
    }

      protected function redirectTo(array $segments)
    {
        return redirect()->to(implode('/', $segments));
    }
}