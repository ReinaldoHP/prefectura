<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

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

            Forms\Components\TextInput::make('municipio')->label('Municipio')->required(),

            Forms\Components\TextInput::make('departamento')->label('Departamento')->required(),

            Forms\Components\TextInput::make('direccion')->label('Dirección')->required(),

            Forms\Components\TextInput::make('celular')->label('Celular')->tel()->required(),

            Forms\Components\TextInput::make('correo')->label('Correo')->email()->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo_documento')->label('Tipo'),
                Tables\Columns\TextColumn::make('numero_documento')->label('Documento')->searchable(),
                Tables\Columns\TextColumn::make('nombres'),
                Tables\Columns\TextColumn::make('apellidos'),
                Tables\Columns\TextColumn::make('municipio'),
                Tables\Columns\TextColumn::make('departamento'),
                Tables\Columns\TextColumn::make('direccion'),
                Tables\Columns\TextColumn::make('celular'),
                Tables\Columns\TextColumn::make('correo')->sortable(),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
