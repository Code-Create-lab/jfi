<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * The public State Association Registration form. Every document type in
 * config('jumpball.association_document_types') is required. "website" is
 * a honeypot.
 */
class StoreStateAssociationRequest extends FormRequest
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
        $documentRules = collect(config('jumpball.association_document_types'))
            ->mapWithKeys(fn (string $label, string $type): array => [
                'documents.'.$type => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            ])
            ->all();

        return [
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', Rule::in(config('jumpball.states'))],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'pincode' => ['nullable', 'regex:/^[1-9][0-9]{5}$/'],
            'society_registration_no' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'president_name' => ['nullable', 'string', 'max:255'],
            'secretary_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9 ]{10,15}$/'],
            'documents' => ['required', 'array'],
            ...$documentRules,
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
            'pincode.regex' => 'Enter a 6-digit PIN code.',
            'phone.regex' => 'Enter a valid phone number (10 to 15 digits).',
            'documents.*.required' => 'Upload this document.',
            'documents.*.mimes' => 'Upload a PDF, JPG or PNG file.',
            'documents.*.max' => 'The file must not be larger than 2 MB.',
            'terms.accepted' => 'Please confirm the declaration.',
            'website.prohibited' => 'Your application could not be submitted. Please try again.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return collect(config('jumpball.association_document_types'))
            ->mapWithKeys(fn (string $label, string $type): array => ['documents.'.$type => $label])
            ->all();
    }
}
