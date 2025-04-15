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
        $user = auth()->user();

        return $form->schema(array_filter([
            Forms\Components\TextInput::make('ciudad')->label('Ciudad')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\DatePicker::make('fecha')->label('Fecha')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('recibido_de')->label('Recibido de')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('direccion')->label('Dirección')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('cc')->label('Cédula')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('telefono')->label('Teléfono')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('suma_letras')->label('Suma en letras')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\Textarea::make('concepto')->label('Concepto')->required()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('marca')->label('Marca')->nullable()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('linea')->label('Línea')->nullable()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\TextInput::make('color')->label('Color')->nullable()->disabled(fn () => $user->isRevisoraFiscal()),
            Forms\Components\Select::make('forma_pago')
                ->label('Forma de pago')
                ->options([
                    'efectivo' => 'Efectivo',
                    'transferencia' => 'Transferencia',
                    'cheque' => 'Cheque',
                ])
                ->default('efectivo')
                ->required()
                ->disabled(fn () => $user->isRevisoraFiscal()),

            // Solo Revisora Fiscal puede ver estos campos
            $user->isRevisoraFiscal() ? Forms\Components\Select::make('estado')
                ->label('Estado del recibo')
                ->options([
                    'pendiente' => 'Pendiente',
                    'aprobado' => 'Aprobado',
                    'denegado' => 'Denegado',
                ])
                ->required() : null,

            $user->isRevisoraFiscal() ? Forms\Components\Textarea::make('observaciones')
                ->label('Observaciones') : null,
        ]));
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('recibido_de')->label('Recibido de')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ciudad')->label('Ciudad')->sortable(),
            Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date(),
            Tables\Columns\TextColumn::make('telefono')->label('Teléfono'),
            Tables\Columns\TextColumn::make('forma_pago')->label('Forma de pago'),
            Tables\Columns\BadgeColumn::make('estado')->label('Estado')->colors([
                'secondary' => 'pendiente',
                'success' => 'aprobado',
                'danger' => 'denegado',
            ]),
            Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime('d/m/Y H:i'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('estado')
                ->label('Filtrar por estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'aprobado' => 'Aprobado',
                    'denegado' => 'Denegado',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            ...(auth()->user()?->isCoordinador() ? [Tables\Actions\DeleteBulkAction::make()] : []),
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

    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()?->isCoordinador() ||
            auth()->user()?->isRevisoraFiscal()
        );
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && (
            auth()->user()?->isCoordinador() ||
            auth()->user()?->isRevisoraFiscal()
        );
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->isCoordinador() || auth()->user()?->isRevisoraFiscal();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isCoordinador();
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isCoordinador();
    }
}
