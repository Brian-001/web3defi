<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'listing_title' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'job_description' => 'required|string',
            'job_roles' => 'required|string',
            'additional_info' => 'nullable|string',
            'tags' => 'required|string',
            'location' => 'required|string',
            'min_salary' => 'required|numeric',
            'max_salary' => 'required|numeric|gte:min_salary', //Ensure max is greater than minimum salary
            'job_type' => 'required|string',
            'listing_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //Log validation errors
        Log::error($validator->errors());

        //Throw a validation exception with errors
        throw new ValidationException($validator);
    }
}
