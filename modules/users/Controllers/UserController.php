<?php

/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 02/6/18
 * Time: 1:29 PM
 */

namespace Modules\Users\Controllers;


use App\Helpers\LogFileHelper;
#use App\Http\Helpers\EmailTemplateHelper;
use Illuminate\Support\Facades\URL;
#use Intervention\Image\Facades\Image;
use Modules\User\Models\UserActivity;
use Mockery\CountValidator\Exception;
#use Modules\Web\Models\UsersProfiles;
use Validator;
use Modules\User\Models\Country;
use App\Helpers\ImageResize;
use Modules\User\Models\Role;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\User\Models\RoleUser;
use Modules\User\Requests\ChangeAdminPasswordRequest;


class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = "User List";
        $data = User::with('relRole')->where('type','admin')->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(30);
        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();

        $marketplaces = MarketPlace::where('status','active')->pluck('title','id')->all();

        //set data
        $action_name = 'User Lists Index ';
        $action_url = 'user/lists';
        $action_detail = @\Auth::user()->username.' '. 'User Lists Index :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'roles'=>$roles,
            'marketplaces' => $marketplaces
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_new()
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = "User List";
        $data = User::with('relRole')->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(30);
        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();

        $marketplaces = MarketPlace::where('status','active')->pluck('title','id')->all();

        //set data
        $action_name = 'User Lists Index ';
        $action_url = 'user/lists';
        $action_detail = @\Auth::user()->username.' '. 'User Lists Index :: ';
        $action_table = 'users';
        //store into user_activity table
        #$useActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.add_new', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'roles'=>$roles,
            'marketplaces' => $marketplaces
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_site_user()
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = "Site User List";

        $data = DB::table('users')
            ->join('roles', 'users.roles_id', '=', 'roles.id')
            ->where('roles.slug','LIKE','user')
            ->where('roles.status','!=','cancel')
            ->select('users.*', 'roles.title as roles_title')
            ->orderBy('users.id', 'DESC')
            ->paginate(30);

        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();


        //set data
        $action_name = 'Site User Lists Index ';
        $action_url = 'user/site-user-list';
        $action_detail = @\Auth::user()->username.' '. 'Site User Lists Index :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'roles'=>$roles
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_cms_user()
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = "User List";

        $data = DB::table('users')
            ->join('roles', 'users.roles_id', '=', 'roles.id')
            ->where('roles.slug','LIKE','admin')
            ->where('roles.status','!=','cancel')
            ->select('users.*', 'roles.title as roles_title')
            ->orderBy('users.id', 'DESC')
            ->paginate(30);

        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();


        //set data
        $action_name = 'CMS User Lists Index ';
        $action_url = 'user/cms-user-list';
        $action_detail = @\Auth::user()->username.' '. 'CMS User Lists Index :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return view('user::users.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'roles'=>$roles
        ]);
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_users(){

        Session::put('url.intended', URL::previous());

        $pageTitle = "Users List | Zogo Medical ";

        $users = DB::table('users')->get();
        $roles = DB::table('roles')->get();
        //$role_title= Role::with('title')->where('id',$role_id)->first();

        return view('user::users.registration', [
            'pageTitle'=>$pageTitle,
            'roles'=>$roles,
            'users'=>$users,

        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_info($id)
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = "User Information | Zogo Medical ";
        $data = DB::table('users')->where('id', $id)->first();


        //set data
        $action_name = 'View User information ';
        $action_url = 'user/show/{id}';
        $action_detail = @\Auth::user()->username.' '. 'View User information by ID :: '.$id;
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return view('user::users.registration', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }



/**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function change_password($id)
    {

        Session::put('url.intended', URL::previous());

        $pageTitle = 'Change Password';

        $data = User::where('id',$id)->first();

        if(!$data){
            return redirect()->back();
        }

        return view('user::users.change_password', [
            'data' => $data,
            'pageTitle'=> $pageTitle
        ]);

    }

    /**
     * @param ChangeAdminPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function do_change_password(ChangeAdminPasswordRequest $request)
    {

        $input = $request->all();

        $user_id = $input['user_id'];

        $user_data = User::where('id',$user_id)->first();

        if(!$user_data)
        {
            return redirect()->back();
        }

        // Change password
        $user_data->password = $input['password'];

        if($user_data->save())
        {
            Session::flash('message', "Password changed successfully.");
        }else{
            Session::flash('danger', "Unable to change password.");
        }

        return redirect()->back();

    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function user_logout()
    {
        $user_activity = new UserActivity();
        $type = @\Auth::user()->type;

        /* Transaction Start Here */
        DB::beginTransaction();
        try{
            $logout_history = [
                'user_id' => @\Auth::user()->id,
                'action_name' => 'user/logout',
                'action_url' => 'user/logout',
                'action_detail' => 'user logged out',
                'action_table' => 'users_activity',
            ];
            $user_activity->create($logout_history);

            Auth::logout();
            Session::flush(); //delete the session
            DB::commit();

            Session::flash('message', 'You are Logged Out !');

        }catch(\Exception $e){
            print_r($e->getMessage());
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('error', $e->getMessage());
        }


        //set data
        $action_name = 'User Logout  ';
        $action_url = 'user/user-logout';
        $action_detail = @\Auth::user()->username.' '. 'User logged out ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        if($type == 'customer')
        {
            return redirect()->route('customer.login');
        }
        elseif($type == 'marketplace')
        {
            return redirect()->route('marketplace.login');
        }
        elseif($type == 'admin')
        {
            return redirect()->route('admin/dashboard');
        }
        return redirect()->route('login');

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reset_password_form()
    {
        $pageTitle = "Reset Password | Zogo Medical ";

        //set data
        $action_name = 'Reset Password  ';
        $action_url = 'user/form-reset-password';
        $action_detail = @\Auth::user()->username.' '. 'Reset Password ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::reset_password.reset_form', [
            'pageTitle'=>$pageTitle
        ]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_profile()
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = 'My Profile | Zogo Medical';

        $user = User::findOrFail(Auth::user()->id);


        //set data
        $action_name = 'My Profile  ';
        $action_url = 'user/profile';
        $action_detail = @\Auth::user()->username.' '. 'My Profile ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.profile', [
            'pageTitle'=>$pageTitle,
            'user'=>$user
        ]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_user()
    {

        $pageTitle = 'User Information';
        $model = new User();

        if($this->isGetRequest())
        {
            $username = Input::get('username');
           // $type = Input::get('type');
            $status = Input::get('status');
            $model = $model->with('relRole')->select('users.*');
            if(isset($username) && !empty($username)){
                $model = $model->where('users.username', 'LIKE', '%'.$username.'%');
            }

            // if(isset($type) && !empty($type)){
            //     $model = $model->where('users.type',  $type);
            // }

            if(isset($status) && !empty($status)){
                $model = $model->where('users.status', '=', $status);
            }
            $data = $model->where('type','admin');
            $data = $model->orderBy('id','DESC');
            $data = $model->paginate(30);
        }else{
            $data = $model->with('relRole')->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(30);
        }

        $roles =  Role::where('type','admin')->where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();

        $marketplaces = MarketPlace::where('status','active')->pluck('title','id')->all();

        //set data
        $action_name = 'Search user  ';
        $action_url = 'user/profile';
        $action_detail = @\Auth::user()->username.' '. 'Search user by :: '.@Input::get('username');
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return view('user::users.index',[
            'pageTitle'=>$pageTitle,
            'data'=>$data,
            'roles'=>$roles,
            'marketplaces' => $marketplaces
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function zogo_partner_search()
    {
        $pageTitle = 'Zogo Partner Lists';
        $model = new User();

        if($this->isGetRequest())
        {
            $username = Input::get('username');
            $type = Input::get('type');
            $status = Input::get('status');
            $model = $model->with('relRole')->select('users.*');
            if(isset($username) && !empty($username)){
                $model = $model->where('users.username', 'LIKE', '%'.$username.'%');
            }

            if(isset($type) && !empty($type) && $type != 'all'){
                if($type == 'unassigned'){
                    $model = $model->where('users.type',  NULL);
                }else{
                    $model = $model->where('users.type',  $type);
                }

            }else{
                $model = $model->whereIn('type',['partner', 'founder', 'partner-founder']);
            }

            if(isset($status) && !empty($status)){
                $model = $model->where('users.status', '=', $status);
            }

            $model = $model->where('market_place_id','5');
            $model = $model->orderBy('id','DESC');
            $data = $model->paginate(30);
        }else{
            $data = $model->with('relRole')
                ->where('market_place_id','5')
                ->whereIn('type',['partner', 'founder', 'partner-founder'])
                ->where('status','!=','cancel')
                ->orderBy('id', 'DESC')
                ->paginate(30);
        }

        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();

        //set data
        $action_name = 'Search user  ';
        $action_url = 'user/zogo-partners-search';
        $action_detail = @\Auth::user()->username.' '. 'Search user by :: '.@Input::get('username');
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return view('user::users.zogo_partners',[
            'pageTitle'=>$pageTitle,
            'data'=>$data,
            'roles'=>$roles,
        ]);
    }


    /**
     * @param Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_user(Requests\UserRequest $request)
    {

        if($this->isPostRequest())
        {
            $input = $request->all();

            /*
             * Input data
             */
            $input_data = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'password'=> $input['password'],
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'type'=>$input['type'],
                'market_place_id'=>$input['market_place_id'],
                'roles_id'=>$input['roles_id'],
                'status'=>$input['status'],
                'remember_token' => str_random(10),
                'csrf_token'=>str_random(10)
            ];

            // Start Transaction
            DB::beginTransaction();
            try {

                // store to users table
                $data = User::create($input_data);

                if(isset($_POST['roles_id'])){
                    $role_model = new RoleUser();
                    $role_model->roles_id = $_POST['roles_id'];
                    $role_model->users_id = $data->id;
                    $role_model->status = 'active';
                    $role_model->save();
                }

                DB::commit();
                Session::flash('message', 'Successfully added!');
                #\App\Http\Helpers\UserLogFileHelper::log_info('user-add', 'Successfully added!', ['Username: '.@$input_data['username']]);

                return redirect()->route('user.lists');

            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());
                #\App\Http\Helpers\UserLogFileHelper::log_error('user-add', $e->getMessage(), ['Username: '.@$input['username']]);
            }
        }



        //set data
        $action_name = 'Store a new  user  ';
        $action_url = 'user/profile';
        $action_detail = @\Auth::user()->username.' '. 'Store a new user :: '.@$input['username'];
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back()->withInput();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_user($id)
    {
        $pageTitle = 'User Information';
        $data = User::with('relRole')->where('id',$id)->first();


        //set data
        $action_name = 'show user ';
        $action_url = 'user/profile';
        $action_detail = @\Auth::user()->username.' '. 'Store a new user :: '.@$id;
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::users.view',
                [
                    'data' => $data,
                    'pageTitle'=>$pageTitle
                ]);
            $contents = $view->render();

            $response['result'] = 'success';
            $response['content'] = $contents;

        }else{

            $response['result'] = 'error';

        }

        return $response;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_user($id)
    {
        Session::put('url.intended', URL::previous());

        $pageTitle = 'Edit User Information';
        $data = User::where('id',$id)->first();
        $user_role = Role::where('id', $data->role_id)->first();

        $roles =  Role::where('title', '!=', 'super-admin')->get(['id', 'title'])->toArray();

        $role_user = RoleUser::where('users_id',$data->id)->first();

        //set data
        $action_name = 'Edit user ';
        $action_url = 'user/edit/{id}';
        $action_detail = @\Auth::user()->username.' '. 'Edit user :: '.@$id;
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.update', [
            'pageTitle'=>$pageTitle,
            'data' => $data,
            'user_role'=>$user_role,
            'roles'=>$roles,
            'role_user' => $role_user
        ]);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Requests\UserRequest $request, $id)
    {
        if($this->isPostRequest())
        {
            #date_default_timezone_set("Asia/Dacca");
            $input = Input::all();
            $user_model = User::findOrFail($id);

            /*
             * Input data
             */
            $input_data = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'type'=>$input['type'],
                'market_place_id'=>$input['market_place_id'],
                'roles_id'=>$input['roles_id'],
                'status'=>$input['status'],
                'remember_token' => str_random(10),
                'csrf_token'=>str_random(10),
            ];


            DB::beginTransaction();
            try{
                //store to users table
                $user_model->update($input_data);

                if(isset($_POST['roles_id'])){

                    DB::table('roles_users')
                        ->where('users_id',$user_model->id)
                        ->delete();

                    $role_model = new RoleUser();
                    $role_model->roles_id = $_POST['roles_id'];
                    $role_model->users_id = $user_model->id;
                    $role_model->status = 'active';
                    $role_model->save();
                }

                DB::commit();
                Session::flash('message', "Successfully Updated");
                #\App\Http\Helpers\UserLogFileHelper::log_info('update-user', 'Successfully Updated!', ['Username:'.@$input['username']]);

                return redirect()->route('user.lists');

            }catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', $e->getMessage());
                #\App\Http\Helpers\UserLogFileHelper::log_error('update-user', 'error!'.$e->getMessage(), ['Username:'.@$input['username']]);
            }
        }


        //set data
        $action_name = 'Store User Data ';
        $action_url = 'user';
        $action_detail = @\Auth::user()->username.' '. 'Store User Data :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back()->withInput();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_user($id)
    {
        $model = User::where('id',$id)->first();

        DB::beginTransaction();
        try {
            if($model->status =='active')
            {
                $model->status = 'cancel';
                $model->last_visit = Null;
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            #\App\Http\Helpers\UserLogFileHelper::log_info('destroy-user', 'Successfully Deleted!change status to cancel',['User id:'.@$model->id]);
        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            #\App\Http\Helpers\UserLogFileHelper::log_error('user-destroy', $e->getMessage(), ['User id:'.@$model->id]);
        }


        //set data
        $action_name = 'Destroy User Data ';
        $action_url = 'user/destroy/{id}';
        $action_detail = @\Auth::user()->username.' '. 'Destroy User Data :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return redirect()->route('user.lists');
    }







    /**
     * Manage Post Request
     *
     * @return void
     */
    public function post_profile_image(Request $request)
    {
        $user_id = \Auth::user()->id;
        $user_model = User::findOrFail($user_id);

        DB::beginTransaction();
        try{
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            //local path to move image and thumb
            $path_image = 'uploads/users/';
            $path_thumb = 'uploads/users/thumb/';

            //image file
            $image = $request->file('image');
            #$imageName = time().'.'.$request->image->getClientOriginalExtension();
            $imageName = time()."-".$request->image->getClientOriginalName();

            //thumb image resize
            $img = Image::make($image->getRealPath());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($path_thumb).$imageName);;

            // original Image
            $request->image->move(public_path($path_image), $imageName);

            //data(s) and store into db
            $user_model->image = $path_image.$imageName;;
            $user_model->thumb = $path_thumb.$imageName;;
            $user_model->save();

            //commit to store in db
            DB::commit();
            Session::flash('message', "You have successfully upload image : ".$imageName );

        }catch (\Exception $e){
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }


        //set data
        $action_name = 'post profile image';
        $action_url = 'user/profile/image';
        $action_detail = @\Auth::user()->username.' '. 'post profile image :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return back();

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_profile_per_user(){
        $pageTitle = 'Edit User Information';
        $data = User::findOrFail(Auth::user()->id);


        //set data
        $action_name = 'edit profile for a user';
        $action_url = 'user/profile/edit';
        $action_detail = @\Auth::user()->username.' '. 'edit profile for a user :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::users.update_profile_user', [
            'pageTitle'=>$pageTitle,
            'data' => $data,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_profile_per_user(Requests\UserRequest $request)
    {
        if($this->isPostRequest())
        {
            #date_default_timezone_set("Asia/Dacca");
            $input = Input::all();
            $user_model = User::findOrFail(Auth::user()->id);

            /*
             * Input data
             */
            $input_data = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'password'=> $input['password'],
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                #'business_id'=> isset($business_id)?$business_id: null
            ];

            DB::beginTransaction();
            try{
                //store to users table
                $user_model->update($input_data);

                DB::commit();
                Session::flash('message', "Successfully Updated Your Profile data ");
                #\App\Http\Helpers\UserLogFileHelper::log_info('update-user', 'Successfully Updated!', ['Username:'.@$input['username']]);
            }catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', $e->getMessage());
                #\App\Http\Helpers\UserLogFileHelper::log_error('update-user', 'error!'.$e->getMessage(), ['Username:'.@$input['username']]);
            }

        }

        //set data
        $action_name = 'update profile for a user';
        $action_url = 'user/profile/update';
        $action_detail = @\Auth::user()->username.' '. 'update profile for a user :: ';
        $action_table = 'users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return back();
    }



    /**
     * @param $id
     * @return string
     */
    public function alter_status($id){
        $response = [];
        $response['result'] = 'error';
        $response['message'] = 'Unknown error';

        $user = User::where('id',$id)->first();

        if(count($user) > 0){

            DB::beginTransaction();
            try {

                if($user->status == 'active'){
                    $user->status = 'inactive';
                }else{
                    $user->status = 'active';

                    // Send mail
                    $zogo_partners_market_place_id = 8;

                    //sending forgot password mail using templates
                    #$template = EmailTemplateHelper::get_mail_template('partners-activation', $zogo_partners_market_place_id);

                    #$mail_body = EmailTemplateHelper::load_mail_preview($template,['load_header'=>true],$user,$marketplace);

                    #$mail_info = EmailTemplateHelper::get_mail_details('partners-activation',$user,$marketplace);

                    #$send_mail = \App\Http\Helpers\SendMail::fire($to=$mail_info['to'], $cc=$mail_info['cc'], $bcc=$mail_info['bcc'], $from=$mail_info['from'], $subject=$mail_info['subject'], $mail_body, $attachment=$mail_info['attachments'],$mail_info['smtp']);
                }

                if($user->save()){
                    $response['result'] = 'success';
                    $response['message'] = 'Partner status successfully changed.';
                }else{
                    $response['message'] = 'Unable to change partner status.';
                }


                DB::commit();
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                $response['message'] = $e->getMessage();
            }

        }else{
            $response['message'] = 'User partner not found.';
        }

        return json_encode($response);
    }



}