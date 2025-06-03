<div
    class="datepicker-container w-full max-w-sm"
    x-data="datepicker(@js($value))"
    x-init="init()"
>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    <div class="relative">
        <!-- Campo combinado Fecha (solo) -->
        <input
            id="{{ $name }}"
            type="text"
            x-model="displayValue"
            x-on:click="open = true"
            placeholder="Selecciona fecha"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            readonly
        >

        <!-- Campo oculto que envía el valor real -->
        <input type="hidden" name="{{ $name }}" x-model="value">

        <!-- Dropdown Fecha -->
        <div
            x-show="open"
            x-on:click.away="open = false"
            x-transition
            class="absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg p-4"
            style="display: none;"
        >
            <!-- Cabecera con mes/año y botones -->
            <div class="flex items-center justify-between mb-3">
                <button
                    x-on:click.prevent="prevMonth()"
                    class="p-1 rounded-full hover:bg-gray-100 transition"
                    aria-label="Mes anterior"
                >
                    &lt;
                </button>
                <div class="text-lg font-semibold text-gray-800" x-text="monthYearLabel"></div>
                <button
                    x-on:click.prevent="nextMonth()"
                    class="p-1 rounded-full hover:bg-gray-100 transition"
                    aria-label="Mes siguiente"
                >
                    &gt;
                </button>
            </div>

            <!-- Días de la semana -->
            <div class="grid grid-cols-7 text-center text-xs font-medium text-gray-500 mb-2">
                <template x-for="day in ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']" :key="day">
                    <div x-text="day"></div>
                </template>
            </div>

            <!-- Cuadrícula de días -->
            <div class="grid grid-cols-7 gap-1 text-sm mb-4">
                <!-- Espacios en blanco por primeros días -->
                <template x-for="blank in blankDays" :key="`b${blank}`">
                    <div class="h-8"></div>
                </template>

                <!-- Días numéricos -->
                <template x-for="(day, idx) in daysInMonth" :key="idx">
                    <div
                        x-text="day"
                        x-on:click="selectDate(day)"
                        class="flex items-center justify-center h-8 cursor-pointer rounded-full transition"
                        :class="{
                            'bg-blue-600 text-white': isSelectedDay(day),
                            'text-gray-900 hover:bg-blue-100': !isSelectedDay(day)
                        }"
                    ></div>
                </template>
            </div>

            <!-- Eliminado selector de hora -->

            <!-- Botones de acción -->
            <div class="mt-4 flex justify-end space-x-2">
                <button
                    x-on:click="clearSelection()"
                    class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition"
                    type="button"
                >
                    Limpiar
                </button>
                <button
                    x-on:click="applySelection()"
                    class="px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition"
                    type="button"
                >
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function datepicker(initialValue = null) {
        return {
            open: false,
            value: initialValue,            // Texto YYYY-MM-DD
            displayValue: '',               // Texto legible para el usuario
            current: new Date(),            // Fecha actual
            selectedDateObj: null,          // Date object completo (fecha solo)
            month: null,
            year: null,
            daysInMonth: [],
            blankDays: [],

            // Comentado por ahora la hora
            // selectedHour: 0,
            // selectedMinute: 0,

            init() {
                if (this.value) {
                    // Parseamos YYYY-MM-DD
                    const [y, m, d] = this.value.split('-').map(Number);
                    this.month = m - 1;
                    this.year = y;
                    this.selectedDateObj = new Date(y, m - 1, d);
                } else {
                    this.selectedDateObj = new Date();
                    this.month = this.selectedDateObj.getMonth();
                    this.year = this.selectedDateObj.getFullYear();
                }

                this.updateCalendar();
                this.updateDisplay();
            },

            updateCalendar() {
                const firstDayOfMonth = new Date(this.year, this.month, 1).getDay();
                const daysCount = new Date(this.year, this.month + 1, 0).getDate();

                this.blankDays = Array.from({ length: firstDayOfMonth });
                this.daysInMonth = Array.from({ length: daysCount }, (_, i) => i + 1);
            },

            isSelectedDay(day) {
                return this.selectedDateObj &&
                    this.selectedDateObj.getDate() === day &&
                    this.selectedDateObj.getMonth() === this.month &&
                    this.selectedDateObj.getFullYear() === this.year;
            },

            selectDate(day) {
                this.selectedDateObj = new Date(this.year, this.month, day);
                this.updateDisplay();
            },

            prevMonth() {
                if (this.month === 0) {
                    this.month = 11;
                    this.year--;
                } else {
                    this.month--;
                }
                this.updateCalendar();
            },

            nextMonth() {
                if (this.month === 11) {
                    this.month = 0;
                    this.year++;
                } else {
                    this.month++;
                }
                this.updateCalendar();
            },

            get monthYearLabel() {
                return new Date(this.year, this.month).toLocaleDateString('es-ES', {
                    month: 'long',
                    year: 'numeric',
                });
            },

            updateDisplay() {
                if (this.selectedDateObj) {
                    // Mostrar en formato dd/MM/yyyy
                    const opts = { day: '2-digit', month: '2-digit', year: 'numeric' };
                    this.displayValue = new Intl.DateTimeFormat('es-ES', opts).format(this.selectedDateObj);
                    
                    // Valor real en formato ISO fecha: YYYY-MM-DD
                    const yyyy = this.selectedDateObj.getFullYear();
                    const mm = String(this.selectedDateObj.getMonth() + 1).padStart(2, '0');
                    const dd = String(this.selectedDateObj.getDate()).padStart(2, '0');
                    this.value = `${yyyy}-${mm}-${dd}`;
                }
            },

            applySelection() {
                if (!this.selectedDateObj) {
                    this.selectedDateObj = new Date(this.year, this.month, 1);
                }
                this.updateDisplay();
                this.open = false;
            },

            clearSelection() {
                this.selectedDateObj = null;
                this.displayValue = '';
                this.value = '';
                this.open = false;

                // Comentado hora para futura implementación
                // this.selectedHour = 0;
                // this.selectedMinute = 0;
            }
        };
    }
</script>
