<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $article_id = $this->route('article','');
        $validation_array = [
            'name' =>  'required|max:60|unique:article,name',
            'description' =>  'required|max:60',
            'image' => 'required',
            'category' => 'required|exists:category,name'
        ];

        if($article_id != '')
        {
            $validation_array['name'] =  'required|max:60|unique:article,name,'.$article_id;
            $validation_array['image'] =  '';
        }
        return $validation_array;
    }
}
