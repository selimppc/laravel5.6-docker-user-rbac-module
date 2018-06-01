<?php
/**
 * Created by PhpStorm.
 * User: mithun
 * Date: 14/3/18
 * Time: 7:06 PM
 */

namespace Modules\User\sRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class ChangeAdminPasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'password'   => 'required|confirmed',
            'password_confirmation'   => 'required',
        ];
    }
}