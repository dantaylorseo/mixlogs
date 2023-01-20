<?php

namespace App\Http\Livewire;

use App\Http\Controllers\C3AppController;
use Livewire\Component;

class C3AppStatus extends Component
{
    public $app;
    public $readyToLoad = false;
 
    public function loadApp()
    {
        $this->readyToLoad = true;
    }

    public function getApp( $app ) {
        $controller = new C3AppController();
        $status = $controller->getAppStatus( $app );
        return $status;
    }

    public function render()
    {
        return view('livewire.c3-app-status', [
            'app_status' => $this->readyToLoad ? $this->getApp( $this->app ) : '',
        ]);
    }
}
