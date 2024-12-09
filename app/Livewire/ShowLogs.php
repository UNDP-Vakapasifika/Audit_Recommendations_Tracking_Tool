<?php

namespace App\Livewire;

// use Livewire\Component;

// class ShowLogs extends Component
// {
//     public function render()
//     {
//         return view('livewire.show-logs');
//     }
// }

// app/Http/Livewire/ShowLogs.php
// namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\ActivityLog;

class ShowLogs extends Component
{
    public $perPage = 20;
    public $startDate;
    public $endDate;

    public function render()
    {
        $logs = ActivityLog::paginate($this->perPage);

        return view('livewire.show-logs', compact('logs'));
    }

    public function updatePerPage()
    {
        $this->resetPage();
    }

    public function filterByDate()
    {
        $this->resetPage();
    }

    private function getLogs()
    {
        $query = ActivityLog::query();

        // Apply date filters if provided
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->paginate($this->perPage);
    }
}
