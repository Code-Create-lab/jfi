<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * The public certificate lookup: Player ID plus date of birth. "website" is
 * the honeypot shared by every public form.
 */
class LookupCertificatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Land on the form, not the top of the page, so the errors are in view.
     */
    protected function getRedirectUrl(): string
    {
        return route('frontend.certificates.index').'#find-certificate';
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'player_id' => ['required', 'string', 'max:30'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'player_id.required' => 'Enter your Player ID.',
            'date_of_birth.required' => 'Enter your date of birth.',
            'date_of_birth.before_or_equal' => 'The date of birth cannot be in the future.',
            'website.prohibited' => 'Your request could not be completed. Please try again.',
        ];
    }
}
