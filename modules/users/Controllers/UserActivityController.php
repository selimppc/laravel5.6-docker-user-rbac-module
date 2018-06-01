<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 01/06/18
 * Time: 3:54 PM
 */

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Input;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\UserActivity;
#use App\Http\Helpers\UserLogFileHelper;
#use Modules\Product\Models\MarketPlace;

class UserActivityController extends Controller
{

     //Get and Post method
    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login_history()
    {
        $pageTitle = 'User Activity';

        $model = new UserActivity();
        $data = $model->with('relUsers')->orderBy('id', 'DESC')->paginate(30);


        return view('user::user_activities.index', [
            'data' => $data,
            'pageTitle'=>$pageTitle
        ]);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_user_history()
    {
        $pageTitle = 'User Activity ';
        $model = new UserActivity();


        if ($this->isGetRequest())
        {
            $title = trim(Input::get('title'));

            $market_place = MarketPlace::where('title','LIKE',$title)->first();

            $model = $model->with('relUsers');

            $model->where('action_name', 'LIKE', '%'.$title.'%');
            $model->orWhere('action_url', 'LIKE', '%'.$title.'%');
            $model->orWhere('action_detail', 'LIKE', '%'.$title.'%');
            $model->orWhere('action_table', 'LIKE', '%'.$title.'%');
            $model->orWhere('created_at', 'LIKE', '%'.$title.'%');
            $model->orWhere('ip_address', 'LIKE', '%'.$title.'%');

            if(count($market_place) > 0)
            {
                $model->orWhere('market_place_id', $market_place->id);
            }

            $data = $model->paginate(30);


        } else {
            $data = $model->with('relUser')->orderBy('id', 'DESC')->paginate(30);
        }


        return view('user::user_activities.index',
        [
            'data' => $data,
            'pageTitle' => $pageTitle,

        ]);
    }

}