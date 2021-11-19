<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApplicationsTable extends Component
{
    public $applications = [];

    public function render()
    {
        $user = User::where( 'id', Auth::user()->id )->with('applications')->first();

        $this->applications = $user->applications;

        return view('livewire.applications-table');
    }
}
