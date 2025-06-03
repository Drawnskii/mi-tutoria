<?php

namespace App\Filament\Coordinator\Widgets;

use App\Models\Request;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeeklyTutoringStats extends Widget
{
    protected static string $view = 'filament.coordinator.widgets.weekly-tutoring-stats';

    public $totalSessions = 0;
    public $totalFeedbacks = 0;
    public $sessionsByTutor = [];
    public $sessionsBySubject = [];
    public $sessionsByDate = [];

    public function mount()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Total sesiones y feedbacks en la semana
        $this->totalSessions = Request::whereBetween('request_date', [$startOfWeek, $endOfWeek])->count();

        $this->totalFeedbacks = DB::table('feedback')
            ->whereIn('request_id', function ($query) use ($startOfWeek, $endOfWeek) {
                $query->select('id')
                    ->from('requests')
                    ->whereBetween('request_date', [$startOfWeek, $endOfWeek]);
            })
            ->count();

        // Sesiones agrupadas por tutor (usando schedules -> tutor_id)
        $this->sessionsByTutor = Request::select('schedules.tutor_id', DB::raw('count(*) as total'))
            ->join('schedules', 'requests.schedule_id', '=', 'schedules.id')
            ->whereBetween('request_date', [$startOfWeek, $endOfWeek])
            ->groupBy('schedules.tutor_id')
            ->with('schedule.tutor.user')
            ->get()
            ->mapWithKeys(function ($item) {
                $name = $item->schedule->tutor->user->name ?? 'Desconocido';
                return [$name => $item->total];
            })
            ->toArray();

        // Sesiones agrupadas por materia (subject)
        $this->sessionsBySubject = Request::select('subject', DB::raw('count(*) as total'))
            ->whereBetween('request_date', [$startOfWeek, $endOfWeek])
            ->groupBy('subject')
            ->pluck('total', 'subject')
            ->toArray();

        // Sesiones agrupadas por fecha
        $dates = [];
        $counts = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dates[] = $date->format('d-m');

            $count = Request::whereDate('request_date', $date)->count();
            $counts[] = $count;
        }
        $this->sessionsByDate = [
            'labels' => $dates,
            'counts' => $counts,
        ];
    }
}
