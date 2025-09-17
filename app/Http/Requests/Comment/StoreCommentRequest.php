<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\SanitizesInput;

class StoreCommentRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'comment' => ['required','string','max:2000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'comment' => $this->sanitizeString($this->input('comment'), true),
        ]);
    }
}
