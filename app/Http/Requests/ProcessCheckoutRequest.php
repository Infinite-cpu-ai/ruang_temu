<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ProcessCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'user';
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'architect_id' => ['required', 'integer', 'exists:users,id'],
            'property_type' => ['required', 'string', Rule::in(['hunian', 'komersial'])],
            'area_size' => ['required', 'numeric', 'min:1', 'max:500000'],
            'units' => ['required', 'integer', 'min:1', 'max:100'],
            'price_per_m2' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'architect_id.required' => 'Arsitek wajib dipilih.',
            'property_type.required' => 'Tipe proyek wajib dipilih.',
            'property_type.in' => 'Tipe proyek tidak valid.',
            'area_size.required' => 'Luas bangunan wajib diisi.',
            'area_size.min' => 'Luas minimal 1 m².',
            'units.required' => 'Jumlah unit wajib diisi.',
            'units.min' => 'Jumlah unit minimal 1.',
            'units.max' => 'Jumlah unit maksimal 100.',
            'price_per_m2.required' => 'Harga per m² wajib diisi.',
            'price_per_m2.min' => 'Harga per m² tidak boleh negatif.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $architect = User::query()->find((int) $this->input('architect_id'));
            if (! $architect || $architect->role !== 'architect') {
                $validator->errors()->add('architect_id', 'Arsitek tidak valid.');
            }
        });
    }

    public function propertyTypeLabel(): string
    {
        return match ($this->validated('property_type')) {
            'hunian' => 'Rumah Hunian',
            'komersial' => 'Komersial / Ruang usaha',
            default => '',
        };
    }
}
