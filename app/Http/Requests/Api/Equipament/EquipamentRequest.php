<?php

namespace App\Http\Requests\Api\Equipament;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipamentRequest extends FormRequest
{
   public function authorize(): bool
   {
      return true;
   }

   public function rules(): array
   {
      return [
         'name' => 'required|string|max:255',
         'description' => 'nullable|string',
         'due_date' => 'nullable|date|unique:equipment,due_date',
         'purchase_date' => 'nullable|date',
      ];
   }
}
