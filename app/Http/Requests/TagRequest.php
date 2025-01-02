<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $tagId = $this->route('tag') ?: 'NULL'; // Get the tag ID of the route(update)

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->isMethod('post')
                    ? 'unique:tags,name'
                    : "unique:tags,name,{$tagId},id",
            ],
        ];
    }
}