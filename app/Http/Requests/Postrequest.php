<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Postrequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category'  => 'required',
            'body' => 'required|max:255',
            'title' => 'required|max:255',

        ];
    }
    public function messages()
        {
            return [
            'title.required' => 'タイトルは必須です',
            'taile.max'      => 'タイトルは255文字以内で入力してください',
            'body.required'  => '本文は必須です',
            'body.max'       => '本文は255文字以内で入力してください',
            'category.required' => 'カテゴリー選択は必須です',
            ];
        }
    
}
