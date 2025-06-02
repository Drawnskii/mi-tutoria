{{-- livewire/schedule-requests-link.blade.php --}}
<div class="flex items-center space-x-2">
    <a 
        href="{{ route('tutor.schedules.requests', $schedule->id) }}" 
        class="flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path d="M8 9a3 3 0 100-6 3 3 0 000 6z" />
            <path fill-rule="evenodd" d="M2 13a6 6 0 0112 0v1H2v-1zm8 2v2H4v-2h6z" clip-rule="evenodd" />
        </svg>
        Solicitudes ({{ $requestCount }})
    </a>
</div>
