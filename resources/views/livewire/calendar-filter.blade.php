<div class="custom-calendar">
    {{-- Controles de mes --}}
    <div class="flex justify-between items-center mb-4">
        <button 
            wire:click="previousMonth"
            class="p-2 rounded-full hover:bg-gray-100"
        >
            &lt;
        </button>
        <h3 class="text-lg font-semibold">
            {{ \Illuminate\Support\Str::ucfirst($currentMonth->translatedFormat('F Y')) }}
        </h3>
        <button 
            wire:click="nextMonth"
            class="p-2 rounded-full hover:bg-gray-100"
        >
            &gt;
        </button>
    </div>

    {{-- Días de la semana --}}
    <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-500 font-medium mb-2">
        @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $day)
            <div>{{ $day }}</div>
        @endforeach
    </div>

    {{-- Días del mes --}}
    <div class="grid grid-cols-7 gap-1">
        @foreach($days as $day)
            <button
                wire:click="selectDates('{{ $day['date'] }}')"
                @class([
                    'h-8 w-8 rounded-full text-sm flex items-center justify-center transition-all',
                    // Si el día está seleccionado, le aplicamos fondo azul y texto blanco
                    'bg-blue-500 text-white' => $day['isSelected'],
                    // Si el día no corresponde al mes actual y no está seleccionado, lo atenuamos
                    'text-gray-400' => !$day['isCurrentMonth'] && !$day['isSelected'],
                    // Si no está seleccionado, permitimos el hover
                    'hover:bg-gray-100' => !$day['isSelected'],
                    'cursor-pointer' => true,
                ])
                title="{{ \Carbon\Carbon::parse($day['date'])->translatedFormat('l, d F Y') }}"
            >
                {{ $day['day'] }}
            </button>
        @endforeach
    </div>
</div>
