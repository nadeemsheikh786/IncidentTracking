<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\SanitizesInput;

class LoginRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'password' => ['required','string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower($this->sanitizeString($this->input('email'))),
        ]);
    }
}
