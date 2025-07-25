<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return session('errors')?->first('email') ?? 'تسجيل الدخول';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->required()
                            ->email()
                            ->autofocus(),

                        TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required(),
                    ]),
            ]);
    }
}
