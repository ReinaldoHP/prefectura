<?php

namespace App\Filament\Resources;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Moto;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('cliente_id')
                ->label('Cliente')
                ->searchable()
                ->options(function () {
                    return \App\Models\Cliente::all()->mapWithKeys(function ($cliente) {
                        return [$cliente->id => "{$cliente->numero_documento}  {$cliente->nombres}  {$cliente->apellidos}"];
                    });
                })
                ->required(),

            // Campos manuales para marca y modelo
            TextInput::make('marca')
                ->label('Marca de la Moto')
                ->required(),

            TextInput::make('modelo')
                ->label('Modelo de la Moto')
                ->required(),

            DatePicker::make('fecha_venta')
                ->label('Fecha de Venta')
                ->default(now())
                ->required(),

            TextInput::make('precio')
                ->label('Precio')
                ->numeric()
                ->required(),

            TextInput::make('observaciones')
                ->label('Observaciones')
                ->nullable(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.numero_documento')->label('Documento'),
                TextColumn::make('cliente.nombres')->label('Cliente'),
                TextColumn::make('marca')->label('Marca'),
                TextColumn::make('modelo')->label('Modelo'),
                TextColumn::make('fecha_venta')->label('Fecha'),
                TextColumn::make('precio')->money('COP'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\VentaResource\Pages\ListVentas::route('/'),
            'create' => \App\Filament\Resources\VentaResource\Pages\CreateVenta::route('/create'),
            'edit' => \App\Filament\Resources\VentaResource\Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
