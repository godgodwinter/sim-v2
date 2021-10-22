<?php

namespace App\View\Components;

use Illuminate\View\Component;

class sweetalertsession extends Component
{
    public $tipe;
    public $status;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tipe,$status)
    {
        $this->tipe=$tipe;
        $this->status=$status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sweetalertsession');
    }
}
