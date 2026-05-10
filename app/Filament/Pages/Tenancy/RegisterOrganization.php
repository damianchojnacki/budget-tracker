<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\CurrencyType;
use App\Models\Currency;
use App\Models\Organization;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Contracts\Support\Htmlable;

class RegisterOrganization extends RegisterTenant
{
    public static function getLabel(): string
    {
        return __('Register organization');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Nie jesteś przypisany do żadnej organizacji. Poproś właściciela organizacji o zaproszenie Cię lub utwórz swoją.';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel(),
                Select::make('currency_id')
                    ->label('Base currency')
                    ->translateLabel()
                    ->searchable()
                    ->options(fn () => Currency::query()
                        ->where('type', CurrencyType::FIAT)
                        ->get()
                        ->mapWithKeys(fn (Currency $currency) => [
                            $currency->id => "{$currency->code} - {$currency->name}",
                        ])
                        ->toArray()
                    )
                    ->native(false)
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Organization
    {
        $organization = new Organization($data);

        $organization->owner()->associate(auth()->user());
        $organization->save();

        auth()->user()->organization()->associate($organization);
        auth()->user()->save();

        return $organization;
    }
}
