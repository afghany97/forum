<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Gate;

use App\Exceptions\ReplyFrequently;

class ReplyRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Gate::denies('create' , new \App\Reply);
    }

    public function failedAuthorization()
    {
        throw new ReplyFrequently('you are replies too much , take a break :)');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamDetect'
        ];
    }
}
