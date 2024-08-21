<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CustomEmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::findOrFail(request()->route('id'));

        if (! hash_equals((string) $this->route('hash'), sha1($user->getEmailForVerification()))) {
            return false;
        }

        return true;
    }
}
