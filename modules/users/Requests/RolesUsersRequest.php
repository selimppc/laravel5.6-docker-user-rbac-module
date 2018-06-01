<?php
/**
 * Created by PhpStorm.
 * User: Mithun Adhikary
 * Date: 14/03/17
 * Time: 6:46 PM
 */
namespace Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;



class RolesUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'roles_id'   => 'required',
            'users_id'   => 'required',
            'status'   => 'required',
        ];
    }
}