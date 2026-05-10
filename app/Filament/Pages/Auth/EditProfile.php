<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastname')
                    ->translateLabel()
                    ->maxLength(255),
                $this->getEmailFormComponent(),
            ]);
    }
}
