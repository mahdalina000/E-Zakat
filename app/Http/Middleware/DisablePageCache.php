<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisablePageCache
{
    /**
     * Cegah browser meng-cache halaman HTML agar setiap navigasi
     * mendapat halaman segar (menghindari campuran build lama & baru
     * yang menyebabkan reload ganda / "ngeleg").
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', '0');
        }

        return $response;
    }
}
