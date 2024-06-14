<?php
    if (! function_exists('city_slug')) {
        /**
         * Получить slug выбранного города
         *
         * @return string|null
        */
        function city_slug(): ?string
        {
            $service = new \App\Services\CityService;
            return $service->currentSlug('/');
        }
    }
