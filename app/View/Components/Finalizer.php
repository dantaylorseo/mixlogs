<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Finalizer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $request, public $response)
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
        return view('components.finalizer');
    }
}
