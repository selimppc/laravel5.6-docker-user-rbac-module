<?php

namespace Modules\Users\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Modules\User\Models\UserActivity;


#use App\Http\Helpers\ActivityLogs;
use Modules\User\Models\Role;
use App\User;
use Modules\User\Models\RoleUser;
use Modules\User\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
#use App\Http\Helpers\UserLogFileHelper;

class RoleUserController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }


    public function index()
    {

        $pageTitle = "User Role List";

        // lists
        $data = RoleUser::join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->join('users', 'users.id', '=', 'roles_users.users_id')
            ->where('roles.slug', '!=', 'superadmin')
            ->select('roles_users.id as ru_id', 'roles.title as r_title', 'users.username as username','roles_users.status as ru_status')
            ->paginate(30);

        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
            ->select('id', 'slug')->get();

        // drop-down - lists
        $user_lists = DB::table('users')
            ->select('id', 'username')->get();


        return view('user::role_user.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'role_lists'=>$role_lists,
            'user_lists' => $user_lists

        ]);

    }

    public function search_user_role()
    {

        $pageTitle = "User Role List";

        $query = trim(Request::get('title'));

        // lists
        $data = RoleUser::where(function ($q) use ($query) {

            $q->orWhereHas('relUser', function ($q) use($query) {
                    $q->where(function ($q) use($query){
                        $q->orWhere('username', 'like', "%$query%");
                    });
                });

            $q->orWhereHas('relRole', function ($q) use($query) {
                $q->where(function ($q) use($query){
                    $q->orWhere('title', 'like', "%$query%");
                });
            });

        })->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->join('users', 'users.id', '=', 'roles_users.users_id')
            ->where('roles.slug', '!=', 'superadmin')
            ->select('roles_users.id as ru_id', 'roles.title as r_title', 'users.username as username','roles_users.status as ru_status')
            ->paginate(30);

        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
            ->select('id', 'slug')->get();

        // drop-down - lists
        $user_lists = DB::table('users')
            ->select('id', 'username')->get();


        return view('user::role_user.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'role_lists'=>$role_lists,
            'user_lists' => $user_lists

        ]);

    }

    public function store_role(Requests\RolesUsersRequest $request)
    {

        $input = $request->all();

        $roles_id = $input['roles_id'];
        $user_id = $input['users_id'];
        $status = $input['status'];

        $role_data = Role::where('id', '=', $roles_id)->exists();
        $user_data = User::where('id', '=', $user_id)->exists();

        if( $role_data && $user_data ){

            $input_data = [
                'roles_id'=> $roles_id,
                'users_id'=> $user_id,
                'status'=> $status,
                'updated_by'=> 0,
                'created_by' => \Auth::user()->id
            ];


            $permission_exists = RoleUser::where('roles_id',$roles_id)->where('users_id',$user_id)->exists();


            if($permission_exists){

                Session::flash('info', 'This role already added!');

            }else{

                /* Transaction Start Here */

                DB::beginTransaction();

                try {

                    if(RoleUser::create($input_data))
                    {
                        //set user activity data
                        $action_name = 'create a use role';
                        $action_url = 'user/add-user-role';
                        $action_detail = @\Auth::user()->username.' '. 'create a user role :: '.@$roles_id;
                        $action_table = 'roles_users';
                        //store into user_activity table
                        $user_act = ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);
                    }

                    DB::commit();
                    #\App\Http\Helpers\UserLogFileHelper::log_info('store-role', 'Successfully Added', ['Role Title '.$roles_id]);
                    Session::flash('message', 'Successfully added!');


                } catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    #\App\Http\Helpers\UserLogFileHelper::log_error('store-role', $e->getMessage(), ['Role Title '.$roles_id]);
                    Session::flash('danger', $e->getMessage());

                }

            }


        }else{
            Session::flash('info', 'This role already added!');
        }

        return redirect()->back();

    }


    public function edit($id)
    {
        $pageTitle = "Update User Role";
        $data = RoleUser::where('id',$id)->first();

        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
            ->select('id', 'slug')->get();

        // drop-down - lists
        $user_lists = DB::table('users')
            ->select('id', 'username')->get();


        //set user activity data
        $action_name = 'Edit use role';
        $action_url = 'user/edit-user-role';
        $action_detail = @\Auth::user()->username.' '. 'edit user role by :: '.@$data->title;
        $action_table = 'roles_users';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::role_user.update',
                [
                    'data' => $data,
                    'pageTitle'=> $pageTitle,
                    'role_lists' => $role_lists,
                    'user_lists' => $user_lists
                ]);
            $contents = $view->render();

            $response['result'] = 'success';
            $response['content'] = $contents;

        }else{

            $response['result'] = 'error';

        }

        return $response;


    }

    public function update(Requests\RolesUsersRequest $request, $id)
    {

        $input = $request->all();

        $dataquery = RoleUser::where('id',$id)->first();


            if( !empty($dataquery))
            {

                $roles_id = $input['roles_id'];
                $user_id = $input['users_id'];
                $status = $input['status'];

                $input_data = [
                    'roles_id'=> $roles_id,
                    'users_id'=> $user_id,
                    'status'=> $status,
                    'updated_by'=> \Auth::user()->id
                ];

                $model = RoleUser::where('id',$id)->first();
                DB::beginTransaction();
                try {
                    $model->update($input_data);
                    DB::commit();
                    #\App\Http\Helpers\UserLogFileHelper::log_info('update-user-role', 'Successfully updated.', ['Role Title '.$roles_id]);
                    Session::flash('message', 'Successfully added!');


                }catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    #UserLogFileHelper::log_error('update-user-role', $e->getMessage(), ['Role Title '.$roles_id]);
                    Session::flash('danger', $e->getMessage());
                }

            }else{
                Session::flash('info', 'This role already added!');
            }



        //set user activity data
        $action_name = 'Update role';
        $action_url = 'user/update-role';
        $action_detail = @\Auth::user()->username.' '. 'update role by :: '.@$input['title'];
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_all(Request $request)
    {
        if ($pr_ids = Input::get('pr_ids')) {

            foreach ($pr_ids as $id) {
                $model = RoleUser::findOrFail($id);
                DB::beginTransaction();
                try {
                    $model->status = 'inactive';
                    $model->save();
                    DB::commit();
                    #UserLogFileHelper::log_info('delete-all-user-role', 'Successfully delete',  ['User role_id'.$id]);

                    Session::flash('message', "Successfully Deleted.");


                } catch(\Exception $e) {
                    DB::rollback();
                    #UserLogFileHelper::log_error('delete-all-user-role', 'Successfully delete.',  ['User role_id'.$id]);
                    Session::flash('danger',$e->getMessage());

                }
            }

        }else{
            Session::flash('message', "Please select role what you delete");
        }

        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete($id)
    {
        $dataquery = RoleUser::where('id',$id)->first();


        if( !empty($dataquery))
        {

            $status = 'inactive';

            $input_data = [
                'status'=> $status,
                'updated_by'=> \Auth::user()->id
            ];

            $model = RoleUser::where('id',$id)->first();
            DB::beginTransaction();
            try {
                $model->update($input_data);
                DB::commit();
                #UserLogFileHelper::log_info('delete-user-role', 'Successfully inactived.', ['Role Title '.$id]);
                Session::flash('message', 'Successfully added!');


            }catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                #UserLogFileHelper::log_error('update-user-role', $e->getMessage(), ['Role Title '.$id]);
                Session::flash('danger', $e->getMessage());
            }

        }else{
            Session::flash('info', 'This role already inactivated!');
        }



        //set user activity data
        $action_name = 'Update role';
        $action_url = 'user/update-role';
        $action_detail = @\Auth::user()->username.' '. 'update role by :: '.@$input['title'];
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back();

    }



}