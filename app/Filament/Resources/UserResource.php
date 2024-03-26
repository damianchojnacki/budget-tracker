<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateBudget;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditBudget;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListBudgets;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Organization;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'fas-users';

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function getBreadcrumb(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->translateLabel()
                    ->required(),
                TextInput::make('lastname')
                    ->translateLabel()
                    ->required(),
                TextInput::make('email')
                    ->translateLabel()
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->minLength(8)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Toggle::make('email_verified_at')
                    ->translateLabel()
                    ->label('Email Verified')
                    ->dehydrateStateUsing(fn (?string $state): ?Carbon => filled($state) ? now() : null),
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var User $user */
        $user = Auth::user();

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('firstname')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lastname')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->translateLabel()
                    ->dateTime()
                    ->hidden(!$user->isAdmin())
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_admin')
                    ->translateLabel()
                    ->label('Admin')
                    ->hidden(!$user->isAdmin())
                    ->sortable()
                    ->disabled(),
            ])
            ->filters([
                Filter::make('is_admin')
                    ->hidden(!$user->isAdmin())
                    ->toggle()
                    ->query(fn (Builder $query) => $query->where('is_admin', true))
                    ->label('Admin'),
            ])
            ->actions([
                EditAction::make()
                    ->hidden(!$user->isAdmin()),
                DeleteAction::make()
                    ->hidden(!$user->isAdmin()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->hidden(!$user->isAdmin()),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
