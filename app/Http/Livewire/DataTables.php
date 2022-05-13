<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class DataTables extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.data-tables',[
            'users' => User::paginate(10)
        ]);
    }

}
