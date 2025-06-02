<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;

class RequestLink extends Component
{
    public Schedule $schedule;
    public int $requestCount = 0;

    public function mount(Schedule $schedule)
    {
        $this->schedule = $schedule;
        // Contar cuántas solicitudes existen para este schedule
        $this->requestCount = $this->schedule->requests()->count();
    }

    public function render()
    {
        return view('livewire.request-link');
    }
}
