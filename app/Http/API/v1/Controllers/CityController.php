<?php

namespace App\Http\API\v1\Controllers;

use App\Services\CityService;
use App\Http\API\v1\Resources\CityResource;
use App\Http\Controllers\Controller as BaseController;
use App\Http\API\v1\Requests\AddCityRequest;
use Illuminate\Http\JsonResponse;

class CityController extends BaseController
{
    /**
     * POST запрос на добавление города
     *
     * @param AddCityRequest $request
     * @param CityService $clientService
     * @return CityResource
    */
    public function add(AddCityRequest $request, CityService $service): CityResource
    {
        return new CityResource(
            $service->add(
                $request->validated()
            )
        );
    }

    /**
     * DELETE запрос на удаление города
     *
     * @param integer $citytId
     * @param CityService $service
     * @return JsonResponse
    */
    public function delete(int $cityId, CityService $service): JsonResponse
    {
        $service->delete($cityId);
        return new JsonResponse('', 204);
    }
   
}
