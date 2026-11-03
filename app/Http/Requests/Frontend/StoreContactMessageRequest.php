<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * The public Contact form. "website" is a honeypot that people never see;
 * a value in it means the form was filled in by a bot.
 */
class StoreContactMessageRequest extends FormRequest
{
    /**
     * The topics offered in the form's subject select.
     *
     * @var list<string>
     */
    public const SUBJECTS = [
        'Player registration',
        'State association recognition',
        'Championships and events',
        'Certificates',
        'Media enquiry',
        'Other',
    ];

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9 ]{10,15}$/'],
            'subject' => ['nullable', 'string', Rule::in(self::SUBJECTS)],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter a valid phone number (10 to 15 digits).',
            'website.prohibited' => 'Your message could not be sent. Please try again.',
        ];
    }
}
