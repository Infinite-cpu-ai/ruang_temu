<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SendChatMessageRequest extends FormRequest
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
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $auth = $this->user();
            if ($auth->role !== 'user') {
                return;
            }

            $receiver = User::query()->find((int) $this->input('receiver_id'));
            if (! $receiver || $receiver->role !== 'architect') {
                $validator->errors()->add('receiver_id', 'Penerima harus berupa arsitek.');

                return;
            }

            if (! $auth->followingArchitects()->where('architect_id', $receiver->id)->exists()) {
                $validator->errors()->add('receiver_id', 'Anda hanya dapat mengobrol dengan arsitek yang sudah Anda ikuti.');
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'receiver_id.required' => 'Penerima pesan wajib dipilih.',
            'receiver_id.exists' => 'Penerima tidak ditemukan.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.max' => 'Pesan maksimal 5000 karakter.',
        ];
    }
}
