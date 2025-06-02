<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Primera fila: 2 columnas --}}
        <div class="grid gap-4 md:grid-cols-2">
            {{-- Columna 1: Filtro --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="bg-white p-6 shadow-sm rounded-xl h-full flex flex-col">
                    <h2 class="text-lg font-semibold mb-4">Filtrar por Día(s)</h2>
                    <livewire:calendar-filter :selected-dates="[]"  />
                </div>
            </div>

            {{-- Columna 2: Crear horario --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="bg-white p-6 shadow-sm rounded-xl h-full flex justify-center flex-col">
                    <h2 class="text-lg font-semibold mb-4">Acciones</h2>
                    <div class="flex justify-center">
                        <button 
                            id="btn-show-create-form"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition"
                        >
                            + Crear Horario
                        </button>
                    </div>

                    {{-- Formulario de creación (oculto inicialmente) --}}
                    <div id="create-form-container" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form 
                            id="form-create-schedule" 
                            action="{{ route('tutor.schedules.store') }}" 
                            method="POST" 
                            class="space-y-4"
                            onsubmit="return validateScheduleForm()"
                        >
                            @csrf

                            <livewire:custom-date-picker 
                                name="date" 
                                label="Fecha" 
                                format="YYYY-MM-DD" 
                                :value="old('date')" 
                            />

                            <div wire:ignore>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Inicio</label>
                                    <div class="flex space-x-2">
                                        <select name="start_hour" id="start_hour" class="w-1/2 border rounded-lg px-2 py-1" required>
                                            @for ($h = 7; $h < 17; $h++)
                                                <option value="{{ $h }}" {{ old('start_hour') == $h ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <input 
                                            type="number" 
                                            name="start_minute" 
                                            id="start_minute" 
                                            min="0" max="59" step="1"
                                            value="{{ old('start_minute', 0) }}"
                                            class="w-1/2 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                            required
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Fin</label>
                                    <div class="flex space-x-2">
                                        <select name="end_hour" id="end_hour" class="w-1/2 border rounded-lg px-2 py-1" required>
                                            @for ($h = 7; $h < 17; $h++)
                                                <option value="{{ $h }}" {{ old('end_hour') == $h ? 'selected' : '' }}>
                                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <input 
                                            type="number" 
                                            name="end_minute" 
                                            id="end_minute" 
                                            min="0" max="59" step="1"
                                            value="{{ old('end_minute', 0) }}"
                                            class="w-1/2 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="available" 
                                    id="available" 
                                    {{ old('available', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                >
                                <label for="available" class="ml-2 text-sm text-gray-700">Disponible</label>
                            </div>

                            <div class="flex gap-3">
                                <button 
                                    type="submit" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition"
                                >
                                    Guardar
                                </button>
                                <button 
                                    type="button" 
                                    id="btn-cancel-create"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition"
                                >
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Segunda fila: Lista de horarios --}}
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <livewire:schedule-list />
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnShow = document.getElementById('btn-show-create-form');
            const formContainer = document.getElementById('create-form-container');
            const btnCancel = document.getElementById('btn-cancel-create');

            btnShow.addEventListener('click', () => {
                formContainer.classList.remove('hidden');
                btnShow.classList.add('hidden');
            });

            btnCancel.addEventListener('click', () => {
                formContainer.classList.add('hidden');
                btnShow.classList.remove('hidden');
            });
        });

        function validateScheduleForm() {
            const sh = parseInt(document.getElementById('start_hour').value);
            const sm = parseInt(document.getElementById('start_minute').value);
            const eh = parseInt(document.getElementById('end_hour').value);
            const em = parseInt(document.getElementById('end_minute').value);

            const start = sh * 60 + sm;
            const end = eh * 60 + em;

            if (start === end) {
                alert('La hora de inicio y la hora de fin no pueden ser iguales.');
                return false;
            }

            if (end < start) {
                alert('La hora de fin no puede ser menor que la hora de inicio.');
                return false;
            }

            return confirm('¿Estás seguro de crear este horario?');
        }
    </script>
    @endpush
</x-layouts.app>
