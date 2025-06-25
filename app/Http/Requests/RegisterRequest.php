<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



final class RegisterRequest extends FormRequest
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
            'login' => ['required', 'string', 'max:50', 'unique:users,login'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                ->letters()
                ->numbers()
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Поле «Логин» обязательно.',
            'login.unique' => 'Такой логин уже используется.',
            'password.min' => 'Пароль должен быть не менее :min символов.',
            'password.confirmed' => 'Поля «Пароль» и «Повтор пароля» не совпадают.',
            'password.letters' => 'Пароль должен содержать хотя бы одну букву.',
            'password.numbers' => 'Пароль должен содержать хотя бы одну цифру.',
        ];
    }
}
