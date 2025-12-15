<?php

namespace App\Http\Requests\Api\Family;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'relative_name' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'status' => 'required|string|max:100',
            'name_vaccine' => 'required|string|max:255',
            'application_date' => 'required|string|max:100',
        ];
    }
}
