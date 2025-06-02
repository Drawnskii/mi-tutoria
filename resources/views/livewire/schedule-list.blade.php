<div>
    <h2 class="text-xl font-semibold mb-4">Horarios {{ $schedules->count() ? '' : '(Ninguno Creados)' }}</h2>

    @if($schedules->isEmpty())
        <p class="text-gray-600">No se ha creado ningún horario para las fechas seleccionadas.</p>
    @else
        <div class="space-y-4">
            @foreach($schedules as $schedule)
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <p class="text-lg font-medium">{{ $schedule->date->format('d/m/Y') }}</p>
                        <p class="text-gray-700">{{ $schedule->start_time->format('H:i') }} – {{ $schedule->end_time->format('H:i') }}</p>
                        <p class="mt-1 text-sm {{ $schedule->available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $schedule->available ? 'Disponible' : 'No Disponible' }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <livewire:request-link :schedule="$schedule" />
                        <a href="{{ route('tutor.schedules.edit', $schedule) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg transition">
                            Editar
                        </a>
                        <form action="{{ route('tutor.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este horario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
