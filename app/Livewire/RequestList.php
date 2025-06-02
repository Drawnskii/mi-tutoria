<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RequestList extends Component
{
    public Schedule $schedule;
    public Collection $requests;

    public function mount(Schedule $schedule)
    {
        $this->schedule = $schedule;
        // Cargar todas las solicitudes con la relación del estudiante y su usuario
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $this->requests = $this->schedule
            ->requests()
            ->join('students', 'requests.student_id', '=', 'students.user_id')
            ->join('users',    'students.user_id',  '=', 'users.id')
            ->select([
                'requests.*',
                'students.career AS student_career',
                'users.name       AS student_name',
                'users.email      AS student_email',
            ])
            ->orderBy('requests.created_at', 'desc')
            ->get();
    }


    public function render()
    {
        return view('livewire.request-list');
    }
}
