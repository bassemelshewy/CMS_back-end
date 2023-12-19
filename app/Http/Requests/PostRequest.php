<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'=> 'required|string|max:100|unique:posts,title,'.$this->id,
            'description'=>'required|string|max:200',
            'content'=>'required|string|max:150',
            'image'=> 'required_without:id|image',
            'categoryID' => 'required|exists:categories,id',
            // 'category_id' => 'required|exists:categories,id', Biiiiiiiiig errrrrrrror لازم يكون الاسم الل ف الفورم
        ];
    }
}
