<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:45',
            'password' => 'required|string|min:3|max:8',
            'email' => 'required|email|unique:users,email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'name.min' => 'O campo nome não pode ter menos de :min caracteres.',
            'password.min' => "A senha deve ter no minímo :min caracteres.",
            'password.max' => "A senha deve ter no máximo :max caracteres.",
            'email.required' => "Por favor insira um e-mail.",
            'email.unique' => "Este e-mail já está cadastrado.",
            'email.email' => "Por favor insira um e-mail válido."
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $messages = array_merge(...array_values($errors));
        throw new HttpResponseException(
            response()->json([
                'message' => "",
                'errors' => $messages
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
