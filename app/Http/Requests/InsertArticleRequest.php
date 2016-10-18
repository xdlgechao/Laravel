<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InsertArticleRequest extends Request
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
            //
            'title'=>'required|regex:/^\S{8,1000}$/',
            'content'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "标题不能为空",
            'title.regex'=>'标题格式不正确',
            'content.required'=>'内容不能为空'
        ];
    }
}
