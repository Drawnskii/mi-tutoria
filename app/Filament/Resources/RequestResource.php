<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Request;
use App\Models\Feedback;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationLabel = 'Mis Solicitudes';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getModelLabel(): string
    {
        return 'Mis Solicitudes';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Mis Solicitudes';
    }

    public static function getTitle(): string
    {
        return 'Mis Solicitudes';
    }

    public static function canCreate(): bool
    {
        return false; // Oculta botón crear
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Aquí si quieres definir formulario
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedule.date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable()
                    ->default('No disponible'),

                Tables\Columns\TextColumn::make('schedule.start_time')
                    ->label('Hora inicio')
                    ->time('H:i')
                    ->sortable()
                    ->default('No disponible'),

                Tables\Columns\TextColumn::make('schedule.end_time')
                    ->label('Hora fin')
                    ->time('H:i')
                    ->sortable()
                    ->default('No disponible'),

                Tables\Columns\TextColumn::make('schedule.tutor.user.name')
                    ->label('Tutor')
                    ->sortable()
                    ->default('Sin tutor'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Materia')
                    ->sortable()
                    ->default('Sin materia'),

                Tables\Columns\TextColumn::make('state.name')
                    ->label('Estado')
                    ->sortable()
                    ->default('Sin estado'),
            ])
            ->actions([
                Action::make('feedback')
                    ->label('Calificar')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->form([
                        Forms\Components\Select::make('rating')
                            ->label('Calificación')
                            ->options([
                                1 => '1',
                                2 => '2',
                                3 => '3',
                                4 => '4',
                                5 => '5',
                            ])
                            ->required()
                            ->default(5),

                        Forms\Components\Textarea::make('comments')
                            ->label('Comentario')
                            ->rows(3),
                    ])
                    ->visible(function ($record) {
                        // Solo visible si estado = 4 y no existe feedback
                        $hasFeedback = Feedback::where('request_id', $record->id)->exists();
                        return $record->state_id === 4 && !$hasFeedback;
                    })
                    ->action(function ($record, array $data) {
                        Feedback::create([
                            'request_id' => $record->id,
                            'rating' => $data['rating'],
                            'comments' => $data['comments'],
                            'date' => now(),
                        ]);

                        Notification::make()
                            ->title('Feedback enviado correctamente')
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([])
            ->bulkActions([])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            // Define relaciones si quieres
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
        ];
    }
}
