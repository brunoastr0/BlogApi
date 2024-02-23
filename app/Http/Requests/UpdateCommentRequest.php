<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{

    public function authorize():bool
    {
        return true;
    }


    public function rules():array
    {
        return [
            "content"=>"required|string"
        ];
    }
}
