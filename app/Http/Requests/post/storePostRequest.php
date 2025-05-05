<?php

namespace App\Http\Requests\Post;

use App\Rules\ValidDate;
use App\Rules\ValidSlug;
use App\Events\UserDataValidationSuccesfuly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class storePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        /**
         * يدل على صلاحية المستخدم مثلا في حالة اليوزر التعديل او الحذف  يكون تعديل البوست لمستخدم الجلسة يعني لصاحب البوست
         */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'slug' => [ 'sometimes','unique:posts', new ValidSlug()],
            'body' => ['required', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'publish_date' => ['date','required' , new ValidDate()],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string'],
        ];
    }
    public function messages():array {
        return [
            'title.required'=>"The title is required",
            'body.required'=>'Please enter the descreption of the post',
            'slug.unique' => 'This slug is used , Try another slug',
            'publish_date.date' => 'Publish date is not correct',
            'publish_date.requird' => 'Publish date is required'
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
            $slug = strtolower(str_replace(' ', '-', $this->input('title'))); // تحويل المسافات إلى شرطات
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug); // إزالة الأحرف غير المسموح بها
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
        event(new UserDataValidationSuccesfuly($this->validated())
    );
    }

}
