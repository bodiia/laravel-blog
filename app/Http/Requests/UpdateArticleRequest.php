<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string title
 * @property string slug
 * @property string content
 * @property array tags
 */
class UpdateArticleRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('update', $this->article);
    }

    public function rules()
    {
        $tags = Tag::all('id')->map(fn ($item) => $item['id']);

        return [
            'title' => 'required|min:10|max:100',
            'slug' => ['required', 'min:10', 'max:100', Rule::unique('articles', 'slug')->ignore($this->article)],
            'content' => 'required|min:100|max:1000',
            'tags' => ['required', 'array', Rule::in($tags)]
        ];
    }
}
