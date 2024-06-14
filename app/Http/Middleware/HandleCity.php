<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Area;
use App\Services\CityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class HandleCity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $service = new CityService();
        $current = $service->getCurrentCity();

        # Получаем город по первой части url
        $city = Area::where('slug', $request->segment(1))->first();
        
        # Если город не найден, проверяем наличие выбранного города в куках
        if ( !$city ) {
            # Если в куках есть город, редиректим на него
            if ( isset($current['slug']) ) return redirect('/'. $current['slug'] . '/' . $request->path(), 301);
        }

        # Если в url указан город и он не соответсвует выбранному, обновляем куку и редиректим на новый slug
        if ( isset($current['slug']) && $current['slug'] != $city->slug ){
            $service->setCity($city);
            return redirect('/' . $request->path(), 301);
        }
        
        return $next($request);
    }
}
