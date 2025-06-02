<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleList extends Component
{
    public $selectedDates = [];

    protected $listeners = ['datesUpdated' => 'updateSelectedDates'];

    public function updateSelectedDates($selectedDates)
    {
        $this->selectedDates = $selectedDates;
    }

    public function render()
    {
        $query = Schedule::query()->where('tutor_id', Auth::id());

        if (!empty($this->selectedDates)) {
            $query->where(function ($q) {
                foreach ($this->selectedDates as $date) {
                    $q->orWhereDate('date', $date);
                }
            });
        }

        $schedules = $query->orderBy('date')->orderBy('start_time')->get();

        return view('livewire.schedule-list', compact('schedules'));
    }
}
