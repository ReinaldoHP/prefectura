<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReciboResource\Pages;
use App\Models\Recibo;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ReciboResource extends Resource
{
    protected static ?string $model = Recibo::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Recibos';
    protected static ?string $modelLabel = 'Recibo';
    protected static ?string $pluralModelLabel = 'Recibos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('ciudad')->label('Ciudad')->required(),
            Forms\Components\DatePicker::make('fecha')->label('Fecha')->required(),
            Forms\Components\TextInput::make('recibido_de')->label('Recibido de')->required(),
            Forms\Components\TextInput::make('direccion')->label('Dirección')->required(),
            Forms\Components\TextInput::make('cc')->label('Cédula')->required(),
            Forms\Components\TextInput::make('telefono')->label('Teléfono')->required(),
            Forms\Components\TextInput::make('suma_letras')->label('Suma en letras')->required(),
            Forms\Components\Textarea::make('concepto')->label('Concepto')->required(),
            Forms\Components\TextInput::make('marca')->label('Marca')->nullable(),
            Forms\Components\TextInput::make('linea')->label('Línea')->nullable(),
            Forms\Components\TextInput::make('color')->label('Color')->nullable(),
            Forms\Components\Select::make('forma_pago')
                ->label('Forma de pago')
                ->options([
                    'efectivo' => 'Efectivo',
                    'transferencia' => 'Transferencia',
                    'cheque' => 'Cheque',
                ])
                ->default('efectivo')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('recibido_de')->label('Recibido de')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ciudad')->label('Ciudad')->sortable(),
            Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date(),
            Tables\Columns\TextColumn::make('telefono')->label('Teléfono'),
            Tables\Columns\TextColumn::make('forma_pago')->label('Forma de pago'),
            Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime('d/m/Y H:i'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecibos::route('/'),
            'create' => Pages\CreateRecibo::route('/create'),
            'edit' => Pages\EditRecibo::route('/{record}/edit'),
        ];
    }

    // 👇 Solo Coordinador puede acceder a Recibos
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()?->isCoordinador();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()?->isCoordinador();
    }
}
