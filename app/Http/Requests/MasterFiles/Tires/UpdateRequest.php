<?php

namespace App\Http\Requests\MasterFiles\Tires;

use Illuminate\Foundation\Http\FormRequest;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
            'id' => 'required|exists:vehicles,id',
            'locations_id' => 'required|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'tire_brand_id' => 'nullable|exists:tire_brands,id',
            'tire_size' => 'nullable',
            'tire_status_id' => 'required|exists:tire_status,id',
            'tire_type_id' => 'required|exists:tire_types,id',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'branding_no'=> 'required|unique:tires,branding_no,' . $this->id,


        ];
    }

    protected function prepareForValidation()
    {
        $purchase_date = Carbon::parse($this->input('purchase_date'))->setTimezone('Asia/Manila')->format('Y-m-d');

        $this->merge([
            'purchase_date' => $purchase_date,
          
        ]);
       
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
