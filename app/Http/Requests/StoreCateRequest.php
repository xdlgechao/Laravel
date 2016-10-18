<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCateRequest extends Request
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
            'name' => 'required|unique:cates',
            'pid'  => 'required|regex:/^\d+$/'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '分类名称不能为空',
            'name.unique'=>'分类名称已经存在',
            'pid.required'=>'父级分类id不能为空',
            'pid.regex'=>'父级分类格式不正确'
        ];
    }
}
