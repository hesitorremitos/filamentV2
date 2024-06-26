<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiplomaAcademicoResource\Pages;
use App\Filament\Resources\DiplomaAcademicoResource\RelationManagers;
use App\Models\Carrera;
use App\Models\DiplomaAcademico;
use App\Models\MencionDA;
use App\Models\Persona;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class DiplomaAcademicoResource extends Resource
{
    protected static ?string $model = DiplomaAcademico::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(4)->schema([
                    Forms\Components\TextInput::make('nro_documento')
                    ->required()
                    ->integer()
                    ->unique('diplomas_academicos', 'nro_documento')
                    ->maxLength(25),
                Forms\Components\DatePicker::make('fecha_emision')
                    ->required()
                    ->date()
                    ->maxDate(now()),
                Forms\Components\TextInput::make('fojas')
                    ->required()
                    ->integer(),
                Forms\Components\TextInput::make('nro_libro')
                    ->required()
                    ->integer(),
                ]),
                
                Forms\Components\Select::make('nivel')
                    ->required()
                    ->options([
                        'TECNICO' => 'Tecnico',
                        'LICENCIATURA' => 'Licenciatura',
                    ]),
                Forms\Components\Select::make('persona_ci')
                    // Mostrar lista  de personas, mostrar los campos de ci y nombre fusionados
                    ->relationship('persona', 'ci')
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return $record->ci . ' - ' . $record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno;
                    })
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('ci')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nombres')
                            ->required()
                            
                            ->maxLength(255),
                        Forms\Components\TextInput::make('apellido_paterno')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('apellido_materno')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sexo')
                            ->required()
                            ->maxLength(1),
                        Forms\Components\DatePicker::make('fecha_nacimiento')
                            ->label('Fecha de Nacimiento')
                            ->required()
                            ->maxDate(now()),
                    ]),
                Forms\Components\Select::make('carrera_id')
                    ->relationship('carrera', 'nombre')
                    ->required(),

                Forms\Components\Select::make('mencion_id')
                    ->relationship('mencion', 'nombre')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('carrera_id')
                            ->options(
                                Carrera::all()->pluck('nombre', 'id')->toArray()
                            )
                ]),
                Forms\Components\FileUpload::make('path')
                    ->disk('local')
                    ->directory('diplomas_academicos')
                    ->getUploadedFileNameForStorageUsing(function (Get $get){
                        $persona = Persona::find($get('persona_ci'));
                        return $persona->getFileName().".pdf";
                    })
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nro_documento')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_emision')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fojas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nro_libro')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nivel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('persona_ci')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mencion_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('carrera_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiplomaAcademicos::route('/'),
            'create' => Pages\CreateDiplomaAcademico::route('/create'),
            'edit' => Pages\EditDiplomaAcademico::route('/{record}/edit'),
        ];
    }
}
