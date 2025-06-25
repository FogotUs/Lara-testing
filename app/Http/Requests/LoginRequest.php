<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



final class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:50',],
            'password' => ['required', 'string', Password::min(8)]
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Поле «Логин» обязательно.',
            'password.min' => 'Пароль должен быть не менее :min символов.',
        ];
    }
}
