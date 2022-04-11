<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Transition extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $log, public $from, public $to)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transition');
    }
}
