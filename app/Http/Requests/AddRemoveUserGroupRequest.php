<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddRemoveUserGroupRequest extends FormRequest
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
        $rules = ['required'];
        $rules[] = Rule::unique('group_users')->where(function ($query) {
            return $query->where('group_id',$this->route('group_id'));
        });
        return [
            'user_id' => $rules
        ];
    }

}