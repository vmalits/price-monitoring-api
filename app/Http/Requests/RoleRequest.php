<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:roles'],
        ];
    }

    public function rolePayload(): array
    {
        return collect($this->validated())
            ->only('name')
            ->toArray();
    }
}
