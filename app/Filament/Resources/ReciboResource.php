<?php

namespace App\Filament\Resources;

use App\Models\Recibo;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Resources\ReciboResource\Pages;

class ReciboResource extends Resource
{
    protected static ?string $model = Recibo::class;

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $fields = [];

        if ($user?->isCoordinador()) {
            $fields = [
                Forms\Components\TextInput::make('ciudad'),
                Forms\Components\DatePicker::make('fecha'),
                Forms\Components\TextInput::make('recibido_de'),
                Forms\Components\TextInput::make('direccion'),
                Forms\Components\TextInput::make('cc'),
                Forms\Components\TextInput::make('telefono'),
                Forms\Components\TextInput::make('suma_letras'),
                Forms\Components\Textarea::make('concepto'),
                Forms\Components\TextInput::make('marca'),
                Forms\Components\TextInput::make('linea'),
                Forms\Components\TextInput::make('color'),
                Forms\Components\Select::make('forma_pago')
                    ->options([
                        'efectivo' => 'Efectivo',
                        'transferencia' => 'Transferencia',
                    ]),
            ];
        } elseif ($user?->isRevisoraFiscal()) {
            $fields = [
                Forms\Components\Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobado' => 'Aprobado',
                    ]),
            ];
        } elseif ($user?->isCaja()) {
            $fields = [
                Forms\Components\TextInput::make('valor_soat'),
                Forms\Components\TextInput::make('valor_tecnomecanica'),
                Forms\Components\TextInput::make('otros_documentos'),
                Forms\Components\TextInput::make('abonos'),
            ];
        }

        return $form->schema($fields);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('ciudad')
                ->label('🏙️ Ciudad')
                ->searchable(),

            Tables\Columns\TextColumn::make('fecha')
                ->label('📅 Fecha')
                ->date('d/m/Y'),

            Tables\Columns\TextColumn::make('recibido_de')
                ->label('👤 Recibido de'),

            Tables\Columns\TextColumn::make('direccion')
                ->label('📍 Dirección'),

            Tables\Columns\TextColumn::make('cc')
                ->label('🆔 Cédula'),

            Tables\Columns\TextColumn::make('telefono')
                ->label('📞 Teléfono'),

            Tables\Columns\TextColumn::make('suma_letras')
                ->label('💰 Suma en Letras'),

            Tables\Columns\TextColumn::make('concepto')
                ->label('📝 Concepto')
                ->limit(40)
                ->tooltip(fn ($record) => $record->concepto),

            Tables\Columns\BadgeColumn::make('forma_pago')
                ->label('💳 Forma de Pago')
                ->colors([
                    'efectivo' => 'success',
                    'transferencia' => 'info',
                ])
                ->formatStateUsing(fn ($state) => ucfirst($state)),

            Tables\Columns\BadgeColumn::make('estado')
                ->label('📌 Estado')
                ->colors([
                    'pendiente' => 'warning',
                    'aprobado' => 'success',
                ])
                ->formatStateUsing(fn ($state) => ucfirst($state)),

            Tables\Columns\TextColumn::make('valor_soat')
                ->label('🚗 Valor SOAT'),

            Tables\Columns\TextColumn::make('valor_tecnomecanica')
                ->label('🔧 Valor Tecno'),

            Tables\Columns\TextColumn::make('otros_documentos')
                ->label('📄 Otros Doc.'),

            Tables\Columns\TextColumn::make('abonos')
                ->label('💵 Abonos'),
        ])
        ->defaultSort('fecha', 'desc');
}



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecibos::route('/'),
            'create' => Pages\CreateRecibo::route('/create'),
            'edit' => Pages\EditRecibo::route('/{record}/edit'),
        ];
    }
}
