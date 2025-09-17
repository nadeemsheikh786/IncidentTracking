<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IncidentStatus;
use App\Http\Requests\Concerns\SanitizesInput;

class UpdateIncidentAdminRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => ['required','in:'.implode(',', IncidentStatus::values())],
            'assigned_to' => ['nullable','exists:users,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->sanitizeString($this->input('status')),
        ]);
    }
}
