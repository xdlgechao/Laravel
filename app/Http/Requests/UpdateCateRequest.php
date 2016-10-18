<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateCateRequest extends Request
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

    public function rules()
    {
        return [
            'name' => 'required',
            'pid'  => 'required|regex:/^\d+$/'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '分类名称不能为空',
            'pid.required'=>'父级分类id不能为空',
            'pid.regex'=>'父级分类格式不正确'
        ];
    }
}
