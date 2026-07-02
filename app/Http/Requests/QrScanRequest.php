<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrScanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('assets.scan');
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'size:64'],
            'scan_location_note' => ['nullable', 'string', 'max:255'],
            'action' => ['nullable', 'string', 'in:verify,mark_stored'],
        ];
    }
}
