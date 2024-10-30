<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Country;
use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'filled',
                'string',
                'min:8',
                'max:255',
            ],
            'description' => [
                'filled',
                'string',
                'min:8',
                'max:255',
            ],
            'category_id' => [
                'filled',
                'numeric',
                Rule::exists(Category::class, 'id'),
            ],
            'country_id' => [
                'filled',
                'numeric',
                Rule::exists(Country::class, 'id'),
            ],
            'status_id' => [
                'filled',
                'numeric',
                Rule::exists(Status::class, 'id'),
            ]
        ];
    }
}
