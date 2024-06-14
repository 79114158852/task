<?php

namespace App\Services;

use Throwable;
use App\Models\Area;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CityService{

    /**
     * Спарсить города
     *
     * @return void
    */
    public function parseCities(): void
    {
        try{
            # Получаем все города
            $cities = json_decode(
                file_get_contents(
                    config('app.city_source')
                ), 
                true
            );

            # Находим id России
            $russiaIndex = array_search(
                'Россия',
                array_column(
                    $cities,
                    'name'
                )
            );
            
            # Рекурсивная обработка субъекта и его дочерних элементов
            $this->handleArea($cities[$russiaIndex]);
        } catch(\Throwable $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Обработать элементы из массива субъектов
     *
     * @param array $item
     * @param integer|null $parent
     * @return void
    */
    private function handleArea(array $item, int $parent = null): void
    {   
        # Находим существующий или создаем новый субъект
        $area = Area::firstOrNew(['external_id' => $item['id']]);
        $area->name = $item['name'];
        $area->parent_id = $parent;

        # Создаем и, при необходимости, добавляем счетчик до тех пор, пока не получим уникальный slug 
        # Для снижения нагрузки на роутер, пишем slug только для субъектов, которые являются населенными пунктами (не имеют дочерних элементов)
        if ( count($item['areas']) == 0 ){
            $area->slug = $this->makeSlug($area->name, $area?->id);
        }

        # Записываем субъект и вызываем функцию для каждого дочернего элемента
        $area->save();
        foreach ( $item['areas'] as $subarea) {
            $this->handleArea($subarea, $area->id);
        }
    }


    /**
     * Сгенерировать уникальный slug
     *
     * @param string $name
     * @param integer|null $id
     * @return string
    */
    private function makeSlug(string $name, ?int $id = null): string
    {
        $slug = Str::slug($name);
        $i = 0;
        while( Area::where('id','<>', $id)->where('slug', $slug)->first() ) {
            $slug = Str::slug($name) . $i;
            $i++;
        }
        return $slug;
    }

    /**
     * Получить древовидный массив субъектов
     *
     * @return array
    */
    public function areas(): string
    {
        $tree = [];
        foreach ( Area::orderBy('name')->get() as $area ){
            $tree[$area['parent_id'] ?? 0][] = $area;
        }

        $result = $this->makeLinks(0, 0, $tree);
        return $result;
    }


    /**
     * Сгенерировать ссылки на города
     *
     * @param integer $parent
     * @param integer $level
     * @param array $tree
     * @param string $string
     * @return string
    */
    private function makeLinks(int $parent, int $level, array $tree, $string = ''): string
    {
        if (isset($tree[$parent])) {
            foreach ($tree[$parent] as $value) {
                $string .= '<div class="tree-item">';
                if ( !isset($tree[$value['id']]) ) {
                    $string .= '<a href="/set/' . $value['id'] . '">' . $value['name'] . '</a>';
                } else {
                    $string .= '<span>' . $value['name'] . '</span>';
                }
                $level = $level + 1;
                $string = $this->makeLinks($value["id"], $level, $tree, $string);
                $level = $level - 1;
                $string .= '</div>';
            }
        }
        return $string;
    }


    /**
     * Получить slug выбранного города
     *
     * @param string $prefix
     * @return string|null
    */
    public function currentSlug(string $prefix = ''): ?string
    {
        $city = $this->getCurrentCity();
        return isset($city['slug']) ? $prefix.$city['slug'] : null;
    }


    /**
     * Получить название выбранного города
     *
     * @return string|null
    */
    public function currentName(): ?string
    {
        $city = $this->getCurrentCity();
        return isset($city['name']) ? $city['name'] : null;
    }


    /**
     * Получить выбранный город из кук
     *
     * @return array
    */
    public function getCurrentCity(): array
    {
        return (array)json_decode((string)Cookie::get('city'), true);
    }


    /**
     * Записать выбранный город в куки
     *
     * @param Area $city
     * @return void
    */
    public function setCity(Area $city)
    {
        Cookie::queue('city', json_encode(['slug' => $city->slug, 'name' => $city->name]));
    }


    /**
     * Добавить город
     *
     * @param array $input
     * @return Area
    */
    public function add(array $input): Area
    {
        try{
            $area = new Area();
            $area->name = $input['name'];
            $area->parent_id = $input['parent'];
            $area->slug = $this->makeSlug($area->name);
            $area->save();
            return $area;
        } catch (\Throwable $e) {
            abort('501', $e->getMessage());
        }
    }


    /**
     * Удалить город
     *
     * @param integer $id
     * @return void
    */
    public function delete(int $id): void
    {   
        try{
            Area::where('id', $id)->firstOrFail()->delete();
        } catch (\Throwable $e) {
            abort('501', $e->getMessage());
        }
    }
}