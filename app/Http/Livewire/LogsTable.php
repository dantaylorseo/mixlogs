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
    public $textSearch = null;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function render()
    {
        $logs = Session::where('application_id', $this->application->id);
        if( !empty( $this->textSearch ) ) {
            $logs = $logs->whereHas('logs', function($query) {
                $query->whereRaw("MATCH(`logs`.`data`) AGAINST(\"'$this->textSearch'\" IN BOOLEAN MODE)");
            });
            //dd( $logs->toSql() );
        } 
        
        if( !empty( $this->sessionid ) ) {
            $logs = $logs->where('sessionid', 'LIKE', '%'.$this->sessionid.'%');
        }
        $logs = $logs->orderByDesc('timestamp')->withCount('logs')->paginate(20);
        
        return view('livewire.logs-table', ['logs' => $logs]);
    }

    public function updatingSessionid() {
        $this->gotoPage(1);
    }

}
