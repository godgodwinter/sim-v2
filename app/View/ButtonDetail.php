<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonDetail extends Component
{
    public $link;
    public $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link,$text)
    {
        $this->link=$link;
        $this->text=$text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-detail');
    }
}
