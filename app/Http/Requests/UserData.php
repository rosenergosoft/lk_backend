<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login_type' => 'required',
            'snils' => 'required_if:login_type,phys',
            'ogrn' => 'required_if:login_type,yur',
            'ohrnip' => 'required_if:login_type,ip',
            'email' => [
                'email',
                'required',
                ],
            'phone' => 'max:11',
            'oldPassword' => 'required_with:newPassword,confirmNewPassword',
            'newPassword' => 'required_with:oldPassword',
            'confirmNewPassword' => 'same:newPassword'
        ];
    }
}
