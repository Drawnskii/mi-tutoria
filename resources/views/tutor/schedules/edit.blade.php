<x-layouts.app>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4">Editar Horario</h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form 
            action="{{ route('tutor.schedules.update', $schedule) }}" 
            method="POST" 
            class="space-y-4"
            onsubmit="return validarHorario()"
        >
            @csrf
            @method('PUT')

            {{-- Fecha --}}
            <div>
                <livewire:custom-date-picker 
                    name="date" 
                    label="Fecha" 
                    format="YYYY-MM-DD" 
                    :value="old('date', $schedule->date->format('Y-m-d'))" 
                />
            </div>

            {{-- Hora de Inicio --}}
            <div wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Inicio</label>
                <div class="flex space-x-2">
                    <select name="start_hour" id="start_hour" class="w-1/2 border rounded-lg px-2 py-1" required>
                        @for ($h = 7; $h < 17; $h++)
                            <option value="{{ $h }}" 
                                {{ old('start_hour', $schedule->start_time->format('H')) == $h ? 'selected' : '' }}>
                                {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                    <input 
                        type="number" 
                        name="start_minute" 
                        id="start_minute" 
                        min="0" 
                        max="59" 
                        step="1"
                        value="{{ old('start_minute', $schedule->start_time->format('i')) }}"
                        class="w-1/2 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        required
                    >
                </div>
            </div>

            {{-- Hora de Fin --}}
            <div wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Fin</label>
                <div class="flex space-x-2">
                    <select name="end_hour" id="end_hour" class="w-1/2 border rounded-lg px-2 py-1" required>
                        @for ($h = 7; $h < 17; $h++)
                            <option value="{{ $h }}" 
                                {{ old('end_hour', $schedule->end_time->format('H')) == $h ? 'selected' : '' }}>
                                {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                    <input 
                        type="number" 
                        name="end_minute" 
                        id="end_minute" 
                        min="0" 
                        max="59" 
                        step="1"
                        value="{{ old('end_minute', $schedule->end_time->format('i')) }}"
                        class="w-1/2 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        required
                    >
                </div>
            </div>

            {{-- Checkbox Disponibilidad --}}
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="available" 
                    id="available" 
                    {{ old('available', $schedule->available) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                >
                <label for="available" class="ml-2 text-sm text-gray-700">Disponible</label>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition"
                >
                    Actualizar
                </button>
                <a 
                    href="{{ route('tutor.schedules.index') }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition text-center"
                >
                    Regresar
                </a>
            </div>
        </form>
    </div>

    {{-- Script de validación --}}
    <script>
        function validarHorario() {
            const sh = parseInt(document.getElementById('start_hour').value);
            const sm = parseInt(document.getElementById('start_minute').value);
            const eh = parseInt(document.getElementById('end_hour').value);
            const em = parseInt(document.getElementById('end_minute').value);

            const inicio = sh * 60 + sm;
            const fin = eh * 60 + em;

            if (inicio === fin) {
                alert('La hora de inicio y fin no pueden ser iguales.');
                return false;
            }

            if (fin < inicio) {
                alert('La hora de fin no puede ser menor que la hora de inicio.');
                return false;
            }

            return confirm('¿Estás seguro de guardar los cambios?');
        }
    </script>
</x-layouts.app>
