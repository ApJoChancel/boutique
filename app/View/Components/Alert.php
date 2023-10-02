<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public string $alert;
    public string $color;

    public function __construct(string $alert, string $color)
    {
        $this->alert = $alert;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
