<?php

namespace App\Http\Requests\Frontend;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * The public Player Registration form. Players register under an approved
 * state association; every document type in
 * config('jumpball.player_document_types') is required. "website" is a
 * honeypot.
 */
class StorePlayerRequest extends FormRequest
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
        $documentRules = collect(config('jumpball.player_document_types'))
            ->mapWithKeys(fn (string $label, string $type): array => [
                'documents.'.$type => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            ])
            ->all();

        return [
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'email' => ['required', 'email', 'max:255', Rule::unique('players', 'email')],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', Rule::in(config('jumpball.states'))],
            'pincode' => ['nullable', 'regex:/^[1-9][0-9]{5}$/'],
            'state_association_id' => [
                'required',
                'integer',
                Rule::exists('state_associations', 'id')->where('status', RegistrationStatus::Approved->value),
            ],
            'documents' => ['required', 'array'],
            ...$documentRules,
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['accepted'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date_of_birth.before' => 'The date of birth must be in the past.',
            'email.unique' => 'A player is already registered with this email address. Sign in instead.',
            'phone.regex' => 'Enter a 10-digit mobile number without +91 or 0.',
            'pincode.regex' => 'Enter a 6-digit PIN code.',
            'state_association_id.required' => 'Choose your state association.',
            'state_association_id.exists' => 'Choose a recognized state association from the list.',
            'documents.*.required' => 'Upload this document.',
            'documents.*.mimes' => 'Upload a PDF, JPG or PNG file.',
            'documents.*.max' => 'The file must not be larger than 2 MB.',
            'terms.accepted' => 'Please confirm the declaration.',
            'website.prohibited' => 'Your registration could not be submitted. Please try again.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'father_name' => "father's or guardian's name",
            'phone' => 'mobile number',
            ...collect(config('jumpball.player_document_types'))
                ->mapWithKeys(fn (string $label, string $type): array => ['documents.'.$type => $label])
                ->all(),
        ];
    }
}
