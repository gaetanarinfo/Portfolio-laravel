<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'url' => ['required', 'string'],
            'small_content' => ['required', 'string'],
            'large_content' => ['required', 'string'],
            'image' => ['required', 'string'],
            'image_bandeau' => ['required', 'string'],
            'categorie' => ['required', 'string'],
            'author' => ['required', 'string'],
            'author_content' => ['required', 'string'],
            'author_link' => ['required', 'string'],
            'avatar' => ['required', 'string'],
            'views' => ['required', 'string'],
            'source' => ['required', 'string'],
            'active' => ['required', 'integer'],
            'url_fb' => ['string'],
            'url_linkedin' => ['string'],
            'url_twitter' => ['string'],
            'email' => ['string'],
        ];
    }
}
