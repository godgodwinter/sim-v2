<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $tipe;
    public $message;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tipe,$message,$icon)
    {  
        $this->tipe = $tipe;
        $this->message = $message;
        $this->icon = $icon;
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
