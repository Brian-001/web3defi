<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'job_roles' => 'required|sting',
            'additional_info' => 'nullable|string',
            'tags' => 'required|string',
            'location' => 'required|string',
            'salary' =>'required|numeric',
            'job_type' => 'required|string|in:onsite,remote,hybrid',
        ];
    }
}