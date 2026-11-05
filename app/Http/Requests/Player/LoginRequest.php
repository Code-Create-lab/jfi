<?php

namespace App\Http\Requests\Player;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Player sign-in with either the email address or the Player ID.
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'login.required' => 'Enter your email address or Player ID.',
            'password.required' => 'Enter your password.',
        ];
    }

    /**
     * An "@" means an email address; anything else is a Player ID, which is
     * stored in capitals (JFI-2026-00001).
     *
     * @return array{email?: string, registration_no?: string, password: string}
     */
    public function credentials(): array
    {
        $login = trim($this->string('login')->toString());

        return [
            ...(str_contains($login, '@') ? ['email' => $login] : ['registration_no' => Str::upper($login)]),
            'password' => $this->string('password')->toString(),
        ];
    }
}
