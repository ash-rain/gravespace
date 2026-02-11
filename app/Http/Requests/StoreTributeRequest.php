<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'body' => ['required', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ];

        if (! $this->user()) {
            $rules['author_name'] = ['required', 'string', 'max:255'];
            $rules['author_email'] = ['nullable', 'email', 'max:255'];
        }

        return $rules;
    }
}
