<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 1/6/18
 * Time: 4:00 PM
 */

namespace Modules\Users\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class UserRequest extends FormRequest
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
        $id = Request::input('id')?Request::input('id'):'';

        if($id == null)
        {
            return [
                'email'   => 'required|unique:users,email,' . $id,
                'username'   => 'required|unique:users,username,' . $id,
                'roles_id'   => 'required' . $id,
                'type' => 'required',
                'market_place_id' => 'required',
            ];
        }else{
            return [
                //
            ];
        }
    }

}