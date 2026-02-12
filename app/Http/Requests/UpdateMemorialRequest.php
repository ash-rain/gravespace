<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemorialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('memorial'));
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'maiden_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'date_of_death' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:date_of_birth'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'place_of_death' => ['nullable', 'string', 'max:255'],
            'obituary' => ['nullable', 'string', 'max:65535'],
            'cover_photo' => ['nullable', 'image', 'max:10240'],
            'profile_photo' => ['nullable', 'image', 'max:10240'],
            'privacy' => ['required', 'in:public,password,invite_only'],
            'memorial_password' => ['nullable', 'required_if:privacy,password', 'string', 'min:4'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:memorials,slug,' . $this->route('memorial')?->id],
            'cemetery_name' => ['nullable', 'string', 'max:255'],
            'cemetery_address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_published' => ['boolean'],
            'theme' => ['nullable', 'string', 'in:classic,garden,celestial,ocean,sunset'],
        ];
    }
}
