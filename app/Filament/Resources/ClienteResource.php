<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('tipo_documento')
                ->label('Tipo de documento')
                ->options([
                    'cc' => 'Cédula de ciudadanía',
                    'ce' => 'Cédula de extranjería',
                    'nit' => 'NIT',
                    'ti' => 'Tarjeta de identidad',
                ])
                ->required(),

            Forms\Components\TextInput::make('numero_documento')->label('Número de documento')->required(),
            Forms\Components\TextInput::make('nombres')->label('Nombres')->required(),
            Forms\Components\TextInput::make('apellidos')->label('Apellidos')->required(),
            Forms\Components\TextInput::make('departamento')->label('Departamento')->required(),
            Forms\Components\TextInput::make('municipio')->label('Municipio')->required(),
            Forms\Components\TextInput::make('direccion')->label('Dirección')->required(),
            Forms\Components\TextInput::make('celular')->label('Celular')->tel()->required(),
            Forms\Components\TextInput::make('correo')->label('Correo')->email()->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipo_documento')->label('Tipo'),
                TextColumn::make('numero_documento')->label('Documento')->searchable(),
                TextColumn::make('nombres'),
                TextColumn::make('apellidos'),
                TextColumn::make('departamento'),
                TextColumn::make('municipio'),
                TextColumn::make('direccion'),
                TextColumn::make('celular'),
                TextColumn::make('correo')->sortable(),

                // ✅ Columna para contar motos
                TextColumn::make('ventas_count')
                    ->label('Motos')
                    ->suffix(' moto(s)')

            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // ✅ Cargar la relación motos_count para evitar el error de SQL
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('ventas');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
