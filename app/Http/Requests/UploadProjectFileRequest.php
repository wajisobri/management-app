<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadProjectFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'project_id' => 'required|integer|exists:App\Models\Project,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:2048',
        ];
    }
}
