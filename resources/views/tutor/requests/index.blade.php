<x-layouts.app>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-6">Solicitudes para el horario del {{ $schedule->date->format('Y-m-d') }}:</h2>

        {{-- Montamos el componente que lista las solicitudes --}}
        <livewire:request-list :schedule="$schedule" />
    </div>
</x-layouts.app>
