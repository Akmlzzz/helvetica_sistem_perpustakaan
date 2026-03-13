<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \App\Models\Pengguna $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        return \Illuminate\Support\Facades\Auth::check() && $user->isAnggota();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_buku' => ['required', 'exists:buku,id_buku'],
            'durasi_pinjam' => ['required', 'integer', 'min:1', 'max:14'],
        ];
    }
}
