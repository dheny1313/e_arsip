<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Components\Component;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

class LoginCustom extends Login
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }


    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label(__('Masukkan NIP / Email'))
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        //$loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
        //   ? 'email'
        // : 'name';

        //return [
        //  $loginType => $data['login'],
        //'password' => $data['password'],
        //];

        return [
            'email' => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }

    // protected string $view = 'filament.pages.auth.login-custom';
}
