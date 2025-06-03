<x-filament-widgets::widget>
    <x-filament::section>

        <div class="space-y-6">

            <div class="grid grid-cols-3 gap-6">
                <x-filament::card>
                    <h2 class="text-lg font-medium text-gray-700">Sesiones esta semana</h2>
                    <p class="mt-2 text-3xl font-bold">{{ $totalSessions }}</p>
                </x-filament::card>

                <x-filament::card>
                    <h2 class="text-lg font-medium text-gray-700">Feedbacks recibidos</h2>
                    <p class="mt-2 text-3xl font-bold">{{ $totalFeedbacks }}</p>
                </x-filament::card>

                <x-filament::card>
                    <h2 class="text-lg font-medium text-gray-700">Días cubiertos</h2>
                    <p class="mt-2 text-3xl font-bold">{{ count($sessionsByDate['labels']) }}</p>
                </x-filament::card>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <x-filament::card>
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Sesiones por tutor</h2>
                    <ul class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($sessionsByTutor as $tutor => $count)
                            <li class="flex justify-between">
                                <span>{{ $tutor }}</span>
                                <span class="font-semibold">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-filament::card>

                <x-filament::card>
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Sesiones por materia</h2>
                    <ul class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($sessionsBySubject as $subject => $count)
                            <li class="flex justify-between">
                                <span>{{ $subject }}</span>
                                <span class="font-semibold">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-filament::card>
            </div>

            <x-filament::card>
                <h2 class="text-lg font-medium text-gray-700 mb-4">Sesiones por día</h2>
                <canvas id="sessionsByDateChart" height="100"></canvas>
            </x-filament::card>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (() => {
                const ctx = document.getElementById('sessionsByDateChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($sessionsByDate['labels']),
                        datasets: [{
                            label: 'Sesiones',
                            data: @json($sessionsByDate['counts']),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1,
                            }
                        }
                    }
                });
            })();
        </script>

    </x-filament::section>
</x-filament-widgets::widget>
