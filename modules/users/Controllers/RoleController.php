<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 01/06/18
 * Time: 3:50 PM
 */

namespace Modules\Users\Controllers;

#use App\Helpers\LogFileHelper;
#use App\Http\Helpers\ActivityLogs;
use Modules\User\Models\Role;
use Modules\User\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Modules\User\Models\UserActivity;
#use App\Http\Helpers\UserLogFileHelper;

class RoleController extends Controller
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
        $role_title = Input::get('title');
        $pageTitle = "List of Role Information";
        $data = Role::where('title', 'LIKE', '%'.$role_title.'%')->paginate(30);


        // drop-down - lists
        $role_lists = DB::table('roles')->where('roles.slug', '!=', 'superadmin')
                ->select('id', 'slug')->get();

        //set data
        $action_name = 'Role Index Page ';
        $action_url = 'user/role';
        $action_detail = @\Auth::user()->username.' '. 'view Role :: Index ';
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        return view('user::role.index',[
            'data'=>$data,
            'pageTitle'=>$pageTitle,
            'role_lists'=>$role_lists,
        ]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_role()
    {

        $pageTitle = 'Role Information';
        $model = new Role();

        if($this->isGetRequest())
        {
            $title = Input::get('title');
            $model = $model->where('title', 'LIKE', '%'.$title.'%');
            $model = $model->orWhere('status', 'LIKE', '%'.$title.'%');
            $data = $model->paginate(30);

        }else{
            $data = Role::where('status', '!=', 'cancel')->paginate(30);
        }
           
        //set user activity data
        $action_name = 'search role';
        $action_url = 'user/search-role';
        $action_detail = @\Auth::user()->username.' '. 'search role by :: '.Input::get('title');
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::role.index',[
            'pageTitle'=>$pageTitle,
            'data'=>$data,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_role(Requests\RolesRequest $request)
    {

        $input = $request->all();

        $role_title=strtolower($input['title']);
        $data= Role::where('title', '=', $role_title)->get();

        if( count($data) <=0)
        {        
            //$input['slug'] = str_slug(strtolower($input['title']));
            $input_data = [
                    'title'=> strtolower($input['title']),
                    'slug'=> str_slug(strtolower($input['title'])),
                    'status'=> $input['status'],
                    'updated_by'=> 0,
                ];

            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                if(Role::create($input_data))
                {
                    //set user activity data
                    $action_name = 'create a role';
                    $action_url = 'user/store-role';
                    $action_detail = @\Auth::user()->username.' '. 'create a role :: '.@$input['title'];
                    $action_table = 'roles';
                    //store into user_activity table
                    $user_act = ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);
                }

                DB::commit();
                #UserLogFileHelper::log_info('store-role', 'Successfully Added', ['Role Title '.$input_data['title']]);
                Session::flash('message', 'Successfully added!');
                
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                #\App\Http\Helpers\UserLogFileHelper::log_error('store-role', $e->getMessage(), ['Role Title '.$input_data['title']]);
                Session::flash('danger', $e->getMessage());
          
            }


        }else{
            Session::flash('info', 'This role already added!');

        }
        return redirect()->back();


    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pageTitle = 'View Role Informations';
        $data = Role::where('slug',$slug)->first();


        //set user activity data
        $action_name = 'View role';
        $action_url = 'user/view-role';
        $action_detail = @\Auth::user()->username.' '. 'view role by :: '.@$data->title;
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::role.view',
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
    public function edit($slug)
    {
        $pageTitle = "Update Role Informations";              
        $data = Role::where('slug',$slug)->first();


        //set user activity data
        $action_name = 'Edit role';
        $action_url = 'user/edit-role';
        $action_detail = @\Auth::user()->username.' '. 'edit role by :: '.@$data->title;
        $action_table = 'roles';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::role.update',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\RolesRequest $request, $slug)
    {
        $input = $request->all();

         $data = str_slug(strtolower($input['title']));
         $dataquery = Role::where('slug',$data)->first();

         $statusquery = DB::table('roles')->select('status')->where('slug',$data)->first();

         if(!isset($statusquery)){

              if( count($dataquery) <=0)
              {
                    $input['slug'] = str_slug(strtolower($input['title']));

                    $model = Role::where('slug',$slug)->first();
                    DB::beginTransaction();
                    try {
                        $model->update($input);
                        DB::commit();
                        #UserLogFileHelper::log_info('update-role', 'Successfully updated.', ['Role Title '.$input['title']]);
                        Session::flash('message', 'Successfully added!');


                    }catch (\Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        DB::rollback();
                        #UserLogFileHelper::log_error('update-role', $e->getMessage(), ['Role Title '.$input['title']]);
                        Session::flash('danger', $e->getMessage());
                    }

              }else{
                    Session::flash('info', 'This role already added!');
              }

        }else{

            $input['slug'] = str_slug(strtolower($input['title']));

            $model = Role::where('slug',$slug)->first();
            DB::beginTransaction();
            try {
                $model->update($input);
                DB::commit();
                Session::flash('message', 'Successfully added!');

            }catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());
            }


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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        if($slug != null){
            $model = Role::where('slug',$slug)->first();
            DB::beginTransaction();
            try {
                if($model->status =='active'){
                    $model->status = 'cancel';
                }else{
                    $model->status = 'active';
                }

                if($model->save())
                {
                    //set data
                    $action_name = 'cancel the role';
                    $action_url = 'user/delete-role';
                    $action_detail = @\Auth::user()->username.' '. 'create a role :: '.$model->title;
                    $action_table = 'roles';
                    //store into user_activity table
                    #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

                }

                DB::commit();
                #UserLogFileHelper::log_info('delete-role', "Successfully Deleted.", ['Role Title '.$model->title]);
                Session::flash('message', "Successfully Deleted.");


            } catch(\Exception $e) {
                DB::rollback();
                #UserLogFileHelper::log_error('delete-role', $e->getMessage(), ['Role Title '.$model->title]);
                Session::flash('danger',$e->getMessage());

            }
        }

        return redirect()->back();
    }



}