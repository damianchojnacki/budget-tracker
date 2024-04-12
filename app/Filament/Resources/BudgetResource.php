<?php

namespace App\Filament\Resources;

use App\Enums\CurrencyType;
use App\Filament\Resources\BudgetResource\RelationManagers\TransactionsRelationManager;
use App\Filament\Resources\BudgetResource\Pages\CreateBudget;
use App\Filament\Resources\BudgetResource\Pages\EditBudget;
use App\Filament\Resources\BudgetResource\Pages\ListBudgets;
use App\Models\Budget;
use App\Models\Currency;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\Builder;
use NumberFormatter;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static ?string $navigationIcon = 'fas-wallet';

    public static function getNavigationLabel(): string
    {
        return __('Budgets');
    }

    public static function getBreadcrumb(): string
    {
        return __('Budgets');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                TextInput::make('amount')
                    ->translateLabel()
                    ->numeric()
                    ->suffix(function (Get $get) {
                        $currency = Currency::find((int) $get('currency'));

                        if (!$currency) {
                            return null;
                        }

                        return $currency->symbol ?? $currency->code;
                    })
                    ->required(),
                Select::make('currency_id')
                    ->label('Currency')
                    ->translateLabel()
                    ->searchable()
                    ->options(fn () => Currency::all()
                        ->map(fn (Currency $currency) => [
                            'id' => $currency->id,
                            'label' => "{$currency->code} - {$currency->name}",
                            'type' => $currency->type->getName(),
                        ])
                        ->groupBy('type')
                        ->map(fn ($currencies, $type) => $currencies->mapWithKeys(fn ($currency) => [$currency['id'] => $currency['label']])
                            ->toArray()
                        )
                        ->toArray()
                    )
                    ->native(false)
                    ->required(),
                ColorPicker::make('color')
                    ->translateLabel()
                    ->required(),
                IconPicker::make('icon')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var Organization $organization */
        $organization = Filament::getTenant();

        return $table
            ->columns([
                IconColumn::make('icon')
                    ->translateLabel()
                    ->icon(fn (string $state) => $state)
                    ->color('none')
                    ->extraAttributes(fn (Budget $record) => ['style' => "color: $record->color"]),
                TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->translateLabel()
                    ->formatStateUsing(function (Budget $record, $state): string|null|false {
                        if (blank($state)) {
                            return null;
                        }

                        $currency = $record->currency->code;

                        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

                        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, strlen((string) ((float) $state)) - strlen((string) ((int) $state)) - 1);

                        return $formatter->formatCurrency($state, $currency);
                    })
                    ->sortable(),
                TextColumn::make('amount_base_currency')
                    ->label(__('Amount')." ({$organization->currency->code})")
                    ->getStateUsing(function (Budget $record) use ($organization) {
                        return $record->selectRaw('(amount / (SELECT rate from currencies where id = currency_id) * (SELECT rate from currencies where code = ?)) as sum', [
                            $organization->currency->code,
                        ])->find($record->id)->sum;
                    })
                    ->money($organization->currency->code)
                    ->sortable(),
                TextColumn::make('currency.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('currency')
                    ->relationship('currency', 'name')
                    ->searchable()
                    ->translateLabel()
                    ->preload(),
                Filter::make('type')
                    ->form([
                        Select::make('type')
                            ->native(false)
                            ->translateLabel()
                            ->options(CurrencyType::collect()->mapWithKeys(fn (CurrencyType $type) => [
                                $type->value => $type->getName(),
                            ])),
                    ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['type'], fn (Builder $query, $value) => $query->whereRelation('currency', 'type', $value)
                    )
                    ),
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
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBudgets::route('/'),
            'create' => CreateBudget::route('/create'),
            'edit' => EditBudget::route('/{record}/edit'),
        ];
    }
}
