<?php

namespace App\View\Components;

use App\Services\CityService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Name extends Component
{
    /**
     * Create a new component instance.
     */

    private string $name; 
    public function __construct()
    {
        $service = new CityService();
        $this->name = $service->currentName() ?? 'Город не выбран';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.name', ['name' => $this->name]);
    }
}
