<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;




class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $modelLabel = 'Usuario';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Correo electrónico')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->required(fn(string $context) => $context === 'create')
                ->dehydrateStateUsing(fn($state) => bcrypt($state))
                ->dehydrated(fn($state) => filled($state)),

            Select::make('role_id')
                ->label('Rol')
                ->relationship('role', 'nombre')
                ->searchable()
                ->preload()
                ->required(),

            Toggle::make('activo')
                ->label('Usuario activo')
                ->visible(fn () => auth()->user()?->isAdmin())
                ->default(true),       
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nombre'),
            TextColumn::make('email')->label('Correo'),
            TextColumn::make('role.nombre')->label('Rol'),
    
            ToggleColumn::make('activo')
                ->label('Activo')
                ->sortable()
                ->onColor('success')
                ->offColor('danger'),
    
            TextColumn::make('created_at')->label('Fecha de creación')->dateTime('d/m/Y H:i'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/crear'),
            'edit' => Pages\EditUser::route('/{record}/editar'),
        ];
    }

    // Solo permite que el administrador vea esta sección
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}
