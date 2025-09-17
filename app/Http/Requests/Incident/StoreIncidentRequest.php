<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IncidentSeverity;
use App\Http\Requests\Concerns\SanitizesInput;

class StoreIncidentRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'description' => ['required','string','max:5000'],
            'severity' => ['required','in:'.implode(',', IncidentSeverity::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->sanitizeString($this->input('title')),
            'description' => $this->sanitizeString($this->input('description'), true),
        ]);
    }
}
