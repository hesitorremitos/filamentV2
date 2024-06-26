<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonaResource\Pages;
use App\Filament\Resources\PersonaResource\RelationManagers;
use App\Models\Persona;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonaResource extends Resource
{
    protected static ?string $model = Persona::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ci')
                    ->required()
                    ->maxLength(25)
                    ->live()
                    ->afterStateUpdated(function ($set, $state) {
                        // Busca en la base de datos basado en el CI ingresado
                        $persona = Persona::where('ci', $state)->first();
                        if ($persona) {
                            $set('nombres', $persona->nombres);
                            $set('apellido_paterno', $persona->apellido_paterno);
                            $set('apellido_materno', $persona->apellido_materno);
                            $set('sexo', $persona->sexo);
                            $set('fecha_nacimiento', $persona->fecha_nacimiento->format('Y-m-d'));
                            $set('finded', true);
                            Notification::make()
                                ->title('Persona encontrada')
                                ->info()
                                ->duration(5000)
                                ->body('La persona con CI ' . $state . ' ya existe en la base de datos')
                                ->send();
                             
                        }else{
                            $set('finded', false);
                        }
                    }),
                Forms\Components\TextInput::make('nombres')
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn (Get $get) => $get('finded')),

                Forms\Components\TextInput::make('apellido_paterno')
                    ->disabled(fn (Get $get) => $get('finded'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_materno')
                    ->disabled(fn (Get $get) => $get('finded'))
                    ->maxLength(255),
                Forms\Components\Radio::make('sexo')
                    ->disabled(fn (Get $get) => $get('finded'))
                    ->options([
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                    ])
                    ->in([ 'M', 'F' ]),
                Forms\Components\DatePicker::make('fecha_nacimiento')
                ->nullable()
                ->disabled(fn (Get $get) => $get('finded')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ci')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombres')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido_paterno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido_materno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->date()
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
            'index' => Pages\ListPersonas::route('/'),
            'create' => Pages\CreatePersona::route('/create'),
            'edit' => Pages\EditPersona::route('/{record}/edit'),
        ];
    }
}
