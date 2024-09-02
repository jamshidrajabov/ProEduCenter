<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class StoreUserRequest extends FormRequest
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
            'surname' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['photo|mimes:jpeg,png,jpg,gif|max:2048'],
            'phone' => ['required', 'string', 'max:13','regex:/^\+998[0-9]{9}$/'],
            'passport' => ['required','regex:/^[A-Za-z]{2}[0-9]{7}$/'],
            'birth' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
    public function messages(): array
    {
        return [
            'surname.required' => 'Familiya kiritilishi shart',
            'surname.string' => 'Familiya satr ko\'rinishda bo\'lishi shart',
            'name.required' => 'Ism kiritilishi shart',
            'name.string' => 'Ism satr ko\'rinishda bo\'lishi shart',
            'phone.required' => 'Telefon raqam kiritilishi shart',
            'phone.regex' => 'Telefon raqam +998XXXXXXXXX formatda bo\'lishi shart',
            'passport.required' => 'Pasport seriya va raqam kiritilishi shart',
            'passport.regex' => 'Pasport XX0000000 ko\'rinishda kiritilishi shart',
            'birth.required'=>'Tug\'ilgan kun kiritilishi shart',
            'email.required'=>'Elektron pochta kiritilishi shart',
            'email.unique'=> 'Elektron pochta oldin ro\'yxatdan o\'tgan',
            'password.required'=>'Parol kiritilishi shart',
            'password.confirmed'=>'Parol tasdiqlanishi shart',
        ];
    }
}
