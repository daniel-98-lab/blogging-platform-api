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
        $postId = $this->route('post') ?: 'NULL'; // Get the post ID of the route(update)

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                $this->isMethod('post')
                    ? 'unique:posts,title'
                    : "unique:posts,title,{$postId},id",
            ],
            'content' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ];
    }
}
