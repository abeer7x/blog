<?php

namespace App\Http\Requests\Post;
use App\Rules\ValidDate;
use App\Rules\ValidSlug;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Events\UserDataValidationSuccesfuly;

class UpdateRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255', 'min:5'],
            'slug' => ['sometimes', Rule::unique('posts')->ignore($this->post), new ValidSlug()], //حتى انا وعم عدل عالبوست نفسو م يقلي الslug موجود
            'body' => ['sometimes', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'publish_date' => ['nullable', 'date', new ValidDate()],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string']
        ];
    }
    public function messages():array {
        return [
            
            'slug.unique' => 'This slug is used , Try another slug',
            'publish_date.date' => 'Publish date is not correct'
        ];
    }
    public function attributes():array{
        return [
            'title' => 'عنوان المنشور',
            'slug' => 'رابط مخصص',
            'publish_date' => 'تاريخ النشر',
            'body' => 'محتوى المنشور',
        ];
    }

    protected function prepareForValidation(){
        if (empty($this->input('slug')) && $this->has('title')) {
            $slug = strtolower(str_replace(' ', '-', $this->input('title')));
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
            $this->merge([
                'slug' => $slug,
            ]);
    }}
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'status' => 'error',
            'errors' => $errors,
        ], 422));
    }

    public function passesValidation(){
        event(new UserDataValidationSuccesfuly($this->validated()));
    
    }

}
