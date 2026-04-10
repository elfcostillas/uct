<?php

namespace App\Http\Requests\MasterFiles\Vehicles;

use Carbon\Carbon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
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
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'model'=> 'required|string|max:255',
            'manufacture_year'=> 'required|integer|min:1900|max:' . date('Y'),
            'plate_no'=> 'required|string|max:255|unique:vehicles,plate_no',
            'veh_identification_no'=> 'nullable|string|max:255|unique:vehicles,veh_identification_no',
            'veh_color'=> 'nullable|string|max:255',
            'assigned_to'=> 'nullable|exists:employees,id',
            'veh_type'=> 'required|exists:vehicle_types,id',
            'tire_count_id'=> 'required|exists:tire_counts,id',
            'veh_code'=> 'nullable|string|max:255|unique:vehicles,veh_code',
            'purchase_date'=> 'nullable|date',
            'supplier_id'=> 'nullable|exists:suppliers,id',
            'veh_remarks'=> 'nullable|string|max:255',
            'veh_status'=> 'required|string|max:255',
            'location_id'=> 'required|integer|exists:locations,id',
            'mixer_drum_no'=> 'nullable|unique:vehicles,mixer_drum_no|string|max:255',
            'engine_no'=> 'nullable|unique:vehicles,engine_no|string|max:255',

            'encoded_by'=> 'required|exists:users,id',
            'encoded_on'=> 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'veh_type.required' => 'The vehicle group field is required.',
            'manufacturer_id.required' => 'The manufacturer field is required.',
            'manufacturer_id.exists' => 'The selected manufacturer is invalid.',
            'model.required' => 'The model field is required.',
            'model.string' => 'The model must be a string.',
            'model.max' => 'The model may not be greater than 255 characters.',
            'manufacture_year.required' => 'The manufacture year field is required.',
            'manufacture_year.integer' => 'The manufacture year must be an integer.',
            'manufacture_year.min' => 'The manufacture year must be at least 1900.',
            'manufacture_year.max' => 'The manufacture year may not be greater than the current year.',
            'plate_no.required' => 'The plate number field is required.',
            'plate_no.string' => 'The plate number must be a string.',
            'plate_no.max' => 'The plate number may not be greater than 255 characters.',
            'plate_no.unique' => 'The plate number has already been taken.',
            'veh_identification_no.string' => 'The vehicle identification number must be a string.',
            'veh_identification_no.max' => 'The vehicle identification number may not be greater than 255 characters.',
            'veh_identification_no.unique' => 'The vehicle identification number has already been taken.',
            // Add more custom messages as needed
        ];
    }

    protected function prepareForValidation()
    {
        $purchase_date = Carbon::parse($this->input('purchase_date'))->setTimezone('Asia/Manila')->format('Y-m-d');

        $this->merge([
            'purchase_date' => $purchase_date,
            'encoded_by' => $this->user()->id,
            'encoded_on' => Carbon::now(),
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


