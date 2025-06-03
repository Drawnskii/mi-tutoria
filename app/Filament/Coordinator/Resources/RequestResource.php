<?php

namespace App\Filament\Coordinator\Resources;

use App\Filament\Coordinator\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationLabel = 'Solicitudes';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getModelLabel(): string
    {
        return 'Solicitudes';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Solicitudes';
    }

    public static function getTitle(): string
    {
        return 'Solicitudes';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('Asunto')
                    ->disabled(),

                Forms\Components\Textarea::make('reason')
                    ->label('Motivo')
                    ->disabled()
                    ->rows(3),

                Forms\Components\Select::make('state_id')
                    ->label('Estado')
                    ->relationship('state', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('schedule.date')
                    ->label('Horario')
                    ->date('d-m-Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('state.name')
                    ->label('Estado')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable(),

                Tables\Columns\TextColumn::make('request_date')
                    ->label('Fecha de solicitud')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Cambiar estado'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Agrega RelationManagers si necesitas, ej: feedback
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
