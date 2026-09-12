<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image', 'max:2048'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'country_id' => ['required', 'integer', Rule::exists('countries', 'id')],
            'state_id' => ['required', 'integer', Rule::exists('states', 'id')->where('country_id', $this->integer('country_id'))],
            'city_id' => ['required', 'integer', Rule::exists('cities', 'id')->where('state_id', $this->integer('state_id'))],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'distinct', Rule::exists('services', 'id')],
            'branches' => ['nullable', 'array'],
            'branches.*' => ['integer', 'distinct', Rule::exists('branches', 'id')],
        ];
    }
}
