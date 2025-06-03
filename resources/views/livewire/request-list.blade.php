{{-- livewire/schedule-requests-list.blade.php --}}
<div class="bg-white shadow rounded-lg p-6">
    {{-- Encabezado con conteo total --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Total de solicitudes: <span class="text-blue-600">{{ $requests->count() }}</span></h3>
        <a 
            href="{{ route('tutor.schedules.index') }}" 
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition text-sm"
        >
            ← Volver a horarios
        </a>
    </div>

    @if($requests->isEmpty())
        <div class="text-center text-gray-500 py-8">
            No hay solicitudes registradas para este horario.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de solicitud</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($requests as $index => $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $request->student_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $request->student_email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $request->subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $request->request_date->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($request->state)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $request->state->id === 1 ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $request->state->id === 2 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->state->id === 3 ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ $request->state->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
