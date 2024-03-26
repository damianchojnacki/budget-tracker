<?php

namespace App\Filament\Resources;

use App\Enums\CurrencyType;
use App\Filament\Resources\CurrencyResource\Pages\CreateCurrency;
use App\Filament\Resources\CurrencyResource\Pages\EditCurrency;
use App\Filament\Resources\CurrencyResource\Pages\ListCurrencies;
use App\Filament\Resources\UserResource\Pages\CreateBudget;
use App\Filament\Resources\UserResource\Pages\EditBudget;
use App\Filament\Resources\UserResource\Pages\ListBudgets;
use App\Models\Budget;
use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'fas-dollar-sign';

    public static function getNavigationLabel(): string
    {
        return __('Currencies');
    }

    public static function getBreadcrumb(): string
    {
        return __('Currencies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Select::make('type')
                    ->translateLabel()
                    ->options(CurrencyType::collect()->mapWithKeys(fn(CurrencyType $type) => [
                        $type->value => $type->getName()
                    ]))
                    ->native(false)
                    ->required(),
                TextInput::make('code')
                    ->translateLabel()
                    ->required(),
                TextInput::make('symbol')
                    ->translateLabel(),
                TextInput::make('rate')
                    ->translateLabel()
                    ->numeric()
                    ->default(1)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('code')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('symbol')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('rate')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListCurrencies::route('/'),
            'create' => CreateCurrency::route('/create'),
            'edit' => EditCurrency::route('/{record}/edit'),
        ];
    }
}
