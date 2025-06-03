<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->name;
        if ($role !== 'tutor') {
            abort(403, 'No estás registrado como tutor.');
        }

        $selectedDates = $request->input('dates', []);
        $query = Schedule::where('tutor_id', $user->id);

        if (is_array($selectedDates) && count($selectedDates) > 0) {
            $parsed = array_map(function ($d) {
                try {
                    return Carbon::parse($d)->startOfDay();
                } catch (\Throwable $e) {
                    return null;
                }
            }, $selectedDates);

            $parsed = array_filter($parsed);

            $query->where(function ($q) use ($parsed) {
                foreach ($parsed as $date) {
                    $q->orWhereDate('date', $date);
                }
            });
        }

        $schedules = $query->orderBy('date', 'asc')
                           ->orderBy('start_time', 'asc')
                           ->get();

        return view('tutor.schedules.index', compact('schedules', 'selectedDates'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->name;
        if ($role !== 'tutor') {
            abort(403, 'Debes ser tutor para crear horarios.');
        }

        $validated = $request->validate([
            'date'         => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_hour'   => ['required', 'integer', 'between:7,17'],
            'start_minute' => ['required', 'integer', 'between:0,59'],
            'end_hour'     => ['required', 'integer', 'between:7,17'],
            'end_minute'   => ['required', 'integer', 'between:0,59'],
            'available'    => ['nullable'],
        ]);

        $start_time = Carbon::createFromTime($validated['start_hour'], $validated['start_minute']);
        $end_time   = Carbon::createFromTime($validated['end_hour'], $validated['end_minute']);

        if ($start_time->gte($end_time)) {
            return back()->withErrors(['end_time' => 'La hora de fin debe ser posterior a la hora de inicio.'])->withInput();
        }

        $schedule = new Schedule();
        $schedule->tutor_id   = $user->id;
        $schedule->date       = Carbon::createFromFormat('Y-m-d', $validated['date'])->startOfDay();
        $schedule->start_time = $start_time;
        $schedule->end_time   = $end_time;
        $schedule->available  = $request->has('available');
        $schedule->save();

        return redirect()->route('tutor.schedules.index')->with('success', 'Horario creado correctamente.');
    }

    public function edit(Schedule $schedule)
    {
        $user = Auth::user();
        $role = $user->role->name;

        if ($role !== 'tutor' || $schedule->tutor_id !== $user->id) {
            abort(403, 'No tienes permiso para editar este horario.');
        }

        return view('tutor.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $user = Auth::user();
        $role = $user->role->name;

        if ($role !== 'tutor' || $schedule->tutor_id !== $user->id) {
            abort(403, 'No tienes permiso para actualizar este horario.');
        }

        $validated = $request->validate([
            'date'         => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_hour'   => ['required', 'integer', 'between:7,17'],
            'start_minute' => ['required', 'integer', 'between:0,59'],
            'end_hour'     => ['required', 'integer', 'between:7,17'],
            'end_minute'   => ['required', 'integer', 'between:0,59'],
            'available'    => ['nullable'],
        ]);

        $start_time = Carbon::createFromTime($validated['start_hour'], $validated['start_minute']);
        $end_time   = Carbon::createFromTime($validated['end_hour'], $validated['end_minute']);

        if ($start_time->gte($end_time)) {
            return back()->withErrors(['end_time' => 'La hora de fin debe ser posterior a la hora de inicio.'])->withInput();
        }

        $schedule->date       = Carbon::createFromFormat('Y-m-d', $validated['date'])->startOfDay();
        $schedule->start_time = $start_time;
        $schedule->end_time   = $end_time;
        $schedule->available  = $request->has('available');
        $schedule->save();

        return redirect()->route('tutor.schedules.index')->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Schedule $schedule)
    {
        $user = Auth::user();
        $role = $user->role->name;

        if ($role !== 'tutor' || $schedule->tutor_id !== $user->id) {
            abort(403, 'No tienes permiso para eliminar este horario.');
        }

        $schedule->delete();

        return redirect()->route('tutor.schedules.index')->with('success', 'Horario eliminado correctamente.');
    }
}
