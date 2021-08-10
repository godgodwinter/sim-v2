<?php

namespace App\View\Components;

use App\Models\tapel;
use Illuminate\View\Component;

class TableTapel extends Component
{
    public $pages;
    public $pagination;
    // public $jmldata;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pages,$pagination)
    {
        // $datas=tapel::all();
        $this->pages=$pages;
        $this->pagination=$pagination;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // $datas=tapel::all();
        // dd($datas);
        return view('components.table-tapel');
    }
}
