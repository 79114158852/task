<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Services\CityService;

class SiteController extends Controller
{
    public function index(CityService $service)
    {
        return view(
            'index',
            ['content' => $service->areas()]
        );
    }

    public function about()
    {
        return view(
            'index',
            ['content' => 'lorem text']
        );
    }

    public function news()
    {
        return view(
            'index',
            ['content' => 'lorem text']
        );
    }

    public function setCity(int $id, CityService $service)
    {
        $city = Area::where('id', $id)->firstOrFail();
        $service->setCity($city);
        return redirect('/' . $city->slug, 301);
    }
}
