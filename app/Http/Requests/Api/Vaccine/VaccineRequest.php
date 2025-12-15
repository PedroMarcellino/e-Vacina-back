<?php

namespace App\Http\Requests\Api\Vaccine;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age_range' => 'required|string|max:255',
            'status' => 'required|string|max:100',
            'application_date' => 'required|string|max:100',
        ];

        
    }
}
