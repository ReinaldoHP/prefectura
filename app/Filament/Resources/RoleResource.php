<?php

namespace App\Filament\Resources;

use App\Models\Role;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nombre') // <-- aquí estaba 'name'
                ->label('Nombre')
                ->required(),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nombre') // <-- aquí también
                ->label('Nombre'),

            TextColumn::make('slug')
                ->label('Slug'),

            TextColumn::make('created_at')
                ->label('Creado')
                ->dateTime(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}

