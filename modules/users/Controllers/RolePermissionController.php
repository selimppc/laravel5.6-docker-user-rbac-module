<?php
namespace Modules\Users\Controllers;

use Modules\User\Models\Permission;
use App\User;
use Modules\User\Models\PasswordReset;
use Illuminate\Http\Request;
use Modules\User\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\User\Models\Role;
use Modules\User\Models\RolePermission;
use Modules\User\Models\RoleUser;
#use App\Http\Helpers\UserLogFileHelper;



class RolePermissionController extends Controller
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



    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pageTitle = "Permission Role List";



        // lists
        $data = DB::table('roles_permissions')
            ->join('permissions', 'permissions.id', '=', 'roles_permissions.permissions_id')
            ->join('roles', 'roles.id', '=', 'roles_permissions.roles_id')
            ->where('roles.slug', '!=', 'superadmin')
            ->select('roles_permissions.id', 'permissions.title as p_title', 'roles.title as r_title', 'roles_permissions.roles_id', 'roles_permissions.status')
            ->paginate(30);

        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
                ->select('id', 'slug')->get();


        return view('user::role_permission.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'role_lists'=>$role_lists,

        ]);

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function search_permission_role(Route $route, Request $request)
    {

        $pageTitle = "Role based Permission :: Lists";

        $q_title = Input::get('query');


        //search result
        $data = DB::table('roles_permissions')
            ->join('permissions', 'permissions.id', '=', 'roles_permissions.permissions_id')
            ->join('roles', 'roles.id', '=', 'roles_permissions.roles_id')
            ->where('permissions.title', 'LIKE', '%' . $q_title . '%')
            ->orWhere('roles.title', 'LIKE', '%' . $q_title . '%')
            ->select('roles_permissions.id', 'permissions.title as p_title', 'roles.title as r_title', 'roles_permissions.roles_id', 'roles_permissions.status')
            ->paginate(30);

        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
            ->select('id', 'slug')->get();

        return view('user::role_permission.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'role_lists'=>$role_lists,

        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        $pageTitle = "Add Permission Role";

        //retrieve role data from roles table
        $role_value = Input::get('roles_id');
        $role_data = Role::findOrFail($role_value);
        $role_title = $role_data->title;
        $role_id = $role_data->id;

        // whereExists() with role-permisison table
        $exists_permission = DB::table('permissions')
            ->whereExists(function ($query) use($role_value){
                $query->select(DB::raw(1))
                    ->from('roles_permissions')
                    ->whereRaw('roles_permissions.permissions_id = permissions.id')
                    ->WhereRaw('roles_permissions.roles_id = ?', [$role_value]);
            })
            ->select('permissions.title', 'permissions.id')->get();


        //whereNotExists() with role-permisison tables
        $not_exists_permission = DB::table('permissions')
            ->whereNotExists(function ($query) use($role_value){
                $query->select(DB::raw(1))
                    ->from('roles_permissions')
                    ->whereRaw('roles_permissions.permissions_id = permissions.id')
                    ->WhereRaw('roles_permissions.roles_id = ?', [$role_value]);
            })
            ->select('permissions.title', 'permissions.id')->get();

        return view('user::role_permission.create', [
            'pageTitle'=> $pageTitle,
            'role_id'=>$role_id,
            'exists_permission' => $exists_permission,
            'not_exists_permission' => $not_exists_permission,
            'role_name'=>$role_title,
            'role_value'=>$role_value
        ]);

    }

    public function store(Requests\RolePermissionRequest $request)
    {

        DB::beginTransaction();
        $input = $request->all();

        // delete all role permission with role id
        RolePermission::where('roles_id','=',$input['roles_id'])->delete();

        #RolePermission::where('roles_id',$input['roles_id'])->delete();

        if(isset($input['permissions_id'])){

            $permissions_id = $input['permissions_id'];

            foreach ($permissions_id as $p_id)
            {

                $model = new RolePermission();
                $model->roles_id = $input['roles_id'];
                $model->permissions_id = $p_id;
                $model->status = 'active';
                /* Transaction Start Here */
                try {
                    $model->save();
                    DB::commit();
                    #UserLogFileHelper::log_info('store-permission-role', 'successfully added',  ['Role-Permission => role_id'.@$model->roles_id]);

                    Session::flash('message', 'Successfully added!');

                } catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    #UserLogFileHelper::log_error('store-permission-role', $e->getMessage(),  ['Role-Permission => role_id'.@$model->roles_id]);

                    Session::flash('danger', $e->getMessage());


                }

            }

        }

        return redirect()->route('user.index.role.permission');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View Permission Role';

        //view data according to ID
        $data = DB::table('roles_permissions')
            ->join('permissions', 'permissions.id', '=', 'roles_permissions.permissions_id')
            ->join('roles', 'roles.id', '=', 'roles_permissions.roles_id')
            ->where('roles.id', $id)
            ->select('roles_permissions.id', 'permissions.title as p_title', 'roles.title as r_title', 'roles_permissions.roles_id', 'roles_permissions.status')
            ->first();

        return view('user::role_permission.view', [
            'data' => $data,
            'pageTitle'=> $pageTitle
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_all(Request $request)
    {
        if($pr_ids = Input::get('pr_ids'))
        {
            foreach ($pr_ids as $id) {
                $model = RolePermission::findOrFail($id);
                DB::beginTransaction();
                try {
                    $model->delete();
                    DB::commit();
                    #UserLogFileHelper::log_info('delete-permission-role', 'Successfully delete',  ['Permission role role_id'.$id]);

                    Session::flash('message', "Successfully Deleted.");


                } catch(\Exception $e) {
                    DB::rollback();
                    #UserLogFileHelper::log_error('delete-permission-role', 'Successfully delete.',  ['Permission role role_id'.$id]);
                    Session::flash('danger',$e->getMessage());

                }
            }
        }else{

            Session::flash('message', "Please select role what you delete");
        }

        return redirect()->back();
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        if($pr_ids = Input::get('pr_ids'))
        {
            foreach ($pr_ids as $id) {
                $model = RolePermission::findOrFail($id);
                DB::beginTransaction();
                try {
                    $model->delete();
                    DB::commit();
                    #UserLogFileHelper::log_info('delete-permission-role', 'Successfully delete',  ['Permission role role_id'.$id]);

                    Session::flash('message', "Successfully Deleted.");


                } catch(\Exception $e) {
                    DB::rollback();
                    #UserLogFileHelper::log_error('delete-permission-role', 'Successfully delete.',  ['Permission role role_id'.$id]);
                    Session::flash('danger',$e->getMessage());

                }
            }
        }else{

            $model = RolePermission::findOrFail($id);

            DB::beginTransaction();
            try {
                $model->delete();
                DB::commit();
                #UserLogFileHelper::log_info('delete-permission-role', 'Successfully deleted ! ',  ['Role-Permission=> role_id'.$id]);
                Session::flash('message', "Successfully Deleted.");

            } catch(\Exception $e)
            {
                DB::rollback();
                #UserLogFileHelper::log_error('delete-permission-role', 'Successfully delete ',  ['Permission role role_id'.$id]);

                Session::flash('danger',$e->getMessage());

            }
        }

        return redirect()->back();
    }
}
