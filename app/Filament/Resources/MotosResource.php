<?php

namespace App\Filament\Resources;

use App\Models\Moto;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class MotoResource extends Resource
{
    protected static ?string $model = Moto::class;
    protected static ?string $navigationIcon = 'heroicon-o-cars';
    protected static ?string $navigationLabel = 'Motos';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID de la moto'),
                TextColumn::make('modelo')->label('Modelo'),
                TextColumn::make('marca')->label('Marca'),
                TextColumn::make('año')->label('Año'),
                TextColumn::make('cliente.nombre')->label('Cliente'),  // Muestra el nombre del cliente
            ])
            ->filters([])
            ->actions([EditAction::make()])
            ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('cliente_id')
                ->label('Cliente')
                ->options(\App\Models\Cliente::all()->pluck('nombre', 'id'))  // Lista de clientes
                ->required(),

            TextInput::make('modelo')->label('Modelo')->required(),
            TextInput::make('marca')->label('Marca')->required(),
            TextInput::make('año')->label('Año')->required(),

            Select::make('marca_modelo_id')
                ->label('Marca y Modelo')
                ->options(
                    MarcaModelo::all()->mapWithKeys(function ($item) {
                        return [$item->id => "{$item->marca} {$item->modelo}"];
                    })
                )
                ->searchable()
                ->required()
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\MotoResource\Pages\ListMotos::route('/'),
            'create' => \App\Filament\Resources\MotoResource\Pages\CreateMoto::route('/create'),
            'edit' => \App\Filament\Resources\MotoResource\Pages\EditMoto::route('/{record}/edit'),
        ];
    }
}

