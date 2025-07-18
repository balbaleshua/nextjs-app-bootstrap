<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request, further authorization can be handled in the controller
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'status' => 'required|in:Draft,Published,Archived',
            'published_at' => 'nullable|date',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
            'author_id.required' => 'The author ID is required.',
            'author_id.exists' => 'The selected author does not exist.',
            'published_at.date' => 'The published date must be a valid date.',
        ];
    }
}