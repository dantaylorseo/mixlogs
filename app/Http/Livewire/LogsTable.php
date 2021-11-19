<?php

namespace App\Http\Livewire;

use App\Models\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LogsTable extends Component
{
    use WithPagination;
    
    public $application;
    public $sessionid = null;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function render()
    {
        $logs = Session::where('application_id', $this->application->id)->orderByDesc('timestamp')->withCount('logs');
        if( !empty( $this->sessionid ) ) {
            $logs = $logs->where('sessionid', 'LIKE', '%'.$this->sessionid.'%');
        }
        $logs = $logs->paginate(10);
        
        return view('livewire.logs-table', ['logs' => $logs]);
    }

    public function updatingSessionid() {
        $this->gotoPage(1);
    }

}
