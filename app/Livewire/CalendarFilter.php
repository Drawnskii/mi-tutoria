<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class CalendarFilter extends Component
{
    public $selectedDates = [];  // Aseguramos que siempre sea un array
    public $currentMonth;
    public $days = [];

    public function mount($selectedDates = [])
    {
        // Si no vienen fechas preseleccionadas, inicializamos en vacío
        $this->selectedDates = is_array($selectedDates) ? $selectedDates : [];
        // Establecemos el mes actual al primer día del mes
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->buildCalendar();
    }

    private function buildCalendar()
    {
        // Calculamos desde el inicio de semana del primer día del mes
        // hasta el fin de semana del último día del mes
        $startDay = $this->currentMonth->copy()->startOfWeek();
        $endDay = $this->currentMonth->copy()->endOfMonth()->endOfWeek();

        $this->days = [];
        $currentDay = $startDay->copy();

        while ($currentDay <= $endDay) {
            $dateString = $currentDay->toDateString();
            $this->days[] = [
                'date' => $dateString,
                'day' => $currentDay->day,
                'isCurrentMonth' => $currentDay->month === $this->currentMonth->month,
                // Marcamos seleccionado si existe en el array
                'isSelected' => in_array($dateString, $this->selectedDates),
            ];
            $currentDay->addDay();
        }
    }

    public function selectDates(string $date)
    {
        if (in_array($date, $this->selectedDates)) {
            // Si ya está seleccionado, lo quitamos
            $this->selectedDates = array_values(array_diff($this->selectedDates, [$date]));
        } else {
            // Si no está, lo agregamos
            $this->selectedDates[] = $date;
        }
        
        // Reconstruimos el calendario para que refresque el estado 'isSelected'
        $this->buildCalendar();

        // Disparamos un evento si alguien necesita saber qué fechas hay seleccionadas
        $this->dispatch('datesUpdated', ['selectedDates' => $this->selectedDates]);
    }

    public function nextMonth()
    {
        $this->currentMonth->addMonth();
        $this->buildCalendar();
    }

    public function previousMonth()
    {
        $this->currentMonth->subMonth();
        $this->buildCalendar();
    }

    public function render()
    {
        return view('livewire.calendar-filter');
    }
}
