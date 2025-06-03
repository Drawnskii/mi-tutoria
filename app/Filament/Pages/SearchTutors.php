<?php

namespace App\Filament\Pages;

use App\Models\Tutor;
use App\Models\Schedule;
use App\Models\Request as TutorRequest;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class SearchTutors extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $title = 'Solicitud';
    protected static string $view = 'filament.pages.search-tutors';

    public $tutor_id;
    public $schedule_id;
    public $subject; // Materia que escribirá el estudiante
    public $message; // Motivo o razón

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('Selecciona un tutor')
                    ->schema([
                        Forms\Components\Select::make('tutor_id')
                            ->label('Tutor')
                            ->options(Tutor::with('user')->get()->pluck('user.name', 'user_id'))
                            ->searchable()
                            ->required(),
                    ]),

                Forms\Components\Wizard\Step::make('Selecciona un horario')
                    ->schema([
                        Forms\Components\Select::make('schedule_id')
                            ->label('Horario Disponible')
                            ->options(function ($get) {
                                $tutorId = $get('tutor_id');
                                if (!$tutorId) return [];

                                return Schedule::where('tutor_id', $tutorId)
                                    ->where('available', true)
                                    ->get()
                                    ->mapWithKeys(fn ($s) => [
                                        $s->id => $s->date->format('d/m/Y') . ' ' . $s->start_time->format('H:i') . '-' . $s->end_time->format('H:i')
                                    ]);
                            })
                            ->required(),
                    ]),

                Forms\Components\Wizard\Step::make('Formulario')
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label('Materia')
                            ->required(),
                        Forms\Components\Textarea::make('message')
                            ->label('Motivo')
                            ->required(),
                    ]),
            ])
                ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Enviar
                    </x-filament::button>
                BLADE)))
                ->skippable(),
        ];
    }

    public function submitRequest(): void
    {
        $this->validate();

        TutorRequest::create([
            'student_id' => Auth::id(),
            'schedule_id' => $this->schedule_id,
            'state_id' => 1, // Ajusta según tu flujo
            'subject' => $this->subject, // Materia que escribió el estudiante
            'reason' => $this->message, // Mensaje o motivo
            'request_date' => now(),
        ]);

        // Marcar horario como no disponible
        $schedule = Schedule::find($this->schedule_id);
        $schedule->available = false;
        $schedule->save();

        Notification::make()
            ->title('¡Solicitud enviada con éxito!')
            ->success()
            ->send();

        $this->redirect('/student');
    }
}
