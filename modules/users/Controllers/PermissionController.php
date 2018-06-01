<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 01/06/18
 * Time: 3:46 PM
 */

namespace Modules\Users\Controllers;

use App\Helpers\LogFileHelper;
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
#use App\Http\Helpers\UserLogFileHelper;
#use App\Http\Helpers\ActivityLogs;

class PermissionController extends Controller
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
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Permission List";
        $title = strtolower(Input::get('title'));

        $data = Permission::where('title', 'LIKE', '%'.$title.'%')->orderBy('id', 'DESC')->paginate(30);


        //set data
        $action_name = 'Permission index';
        $action_url = 'user/permission';
        $action_detail = @\Auth::user()->username.' '. 'View all list of permission ';
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::permission.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            
        ]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_permission()
    {

        $pageTitle = 'Permission Information';
        $model = new Permission();

        if($this->isGetRequest())
        {
            $title = trim(Input::get('title'));
            $model = $model->where('title', 'LIKE', '%'.$title.'%');
            $model = $model->orWhere('route_url', 'LIKE', '%'.$title.'%');
            $data = $model->paginate(30);

        }else{
            $data = Permission::where('status', '!=', 'cancel')->paginate(30);
        }


        //set data
        $action_name = 'Search Permission';
        $action_url = 'user/permission-search';
        $action_detail = @\Auth::user()->username.' '. 'search permission by  :: '.@Input::get('title');
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return view('user::permission.index',[
            'pageTitle'=>$pageTitle,
            'data'=>$data,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        // $title = Input::get('title');
        $title = strtolower($input['title']);
        $title_upper_case = ucwords($title);
        $route_url= str_slug(strtolower($input['title']));

        $description=$input['description'];
        
        $permission_exists = Permission::where('route_url',$route_url)->exists();

        if($permission_exists){
             Session::flash('info',' Already Exists.');
        }else{
            /* Transaction Start Here */

            $input_data = [
            'title'=> $title_upper_case,
            'route_url'=>$route_url,
            'description'=> $description,
            'updated_by'=> 0,            
            ];

            DB::beginTransaction();
            try {
                Permission::create($input_data);
                DB::commit();
                #UserLogFileHelper::log_info('store-permission', $message = 'Successfully added!', ['Permission title : '.$input['title']]);
                Session::flash('message', 'Successfully added!');

            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                #UserLogFileHelper::log_error('store-permission', $e->getMessage(), ['Permission title: '.$input['title']]);
                Session::flash('danger', $e->getMessage());

            }
        }


        //set data
        $action_name = 'Store data into Permission';
        $action_url = 'user/permission';
        $action_detail = @\Auth::user()->username.' '. 'store data permission   :: ';
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $route_url
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View Permission';
        $data = Permission::where('id',$id)->first();

        //set data
        $action_name = 'view data from Permission';
        $action_url = 'user/view-permission/{id}';
        $action_detail = @\Auth::user()->username.' '. 'view data from permission  by id :: '.$id;
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);


        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::permission.view',
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
     * @param  string  $route_url
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Update Permission Informations';
        $data = Permission::where('id',$id)->first();

        //set data
        $action_name = 'view data from Permission';
        $action_url = 'user/edit-permission/{id}';
        $action_detail = @\Auth::user()->username.' '. 'edit data from permission  by id :: '.$id;
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        if(count($data) > 0)
        {

            $view = \Illuminate\Support\Facades\View::make('user::permission.update',
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
     * @param  string  $route_url
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PermissionRequest $request, $id)
    {
        $input = $request->all();

        $route_url = $input['route_url'];
        $description=$input['route_url'];
        $permission_exists = Permission::where('id',$id)->exists();

         if(count($permission_exists)<2 ){       
            $model = Permission::where('id',$id)->first();   
            $title = Input::get('title');       
            $input['title'] = $title;
            $input['route_url'] = $input['route_url'];
            $input['description'] = $description;

;
            DB::beginTransaction();
            try {
                $model->update($input);
                DB::commit();
                #UserLogFileHelper::log_info('update-permission', 'Successfully updated', ['Permission : '.$input['route_url']]);
                Session::flash('message', "Successfully Updated");

            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                #UserLogFileHelper::log_error('update-permission', $e->getMessage(), ['Permission title: '.$input['route_url']]);
                Session::flash('danger', $e->getMessage());

            }
        }else{
             Session::flash('info', 'This permission already added!');
        }

        //set data
        $action_name = 'update data from Permission';
        $action_url = 'user/update-permission/{id}';
        $action_detail = @\Auth::user()->username.' '. 'update data from permission  by id :: '.$id;
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $route_url
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Permission::where('id',$id)->first();

        DB::beginTransaction();
        try {
            $model->delete();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            #UserLogFileHelper::log_info('delete-permission', 'Successfully delete', ['Permission id: '.$model->id]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            #UserLogFileHelper::log_error('delete-permission', $e->getMessage(), ['Permission id: '.$model->id]);
        }


        //set data
        $action_name = 'deleted data from Permission';
        $action_url = 'user/delete-permission/{id}';
        $action_detail = @\Auth::user()->username.' '. 'deleted data from permission  by id :: '.$id;
        $action_table = 'permissions';
        //store into user_activity table
        #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

       return redirect()->back();
    }

    /**
     * Store the specified resource .
     *
     * @return \Illuminate\Http\Response
     */
    public function route_in_permission()
    {

        $routeCollection = Route::getRoutes();


        foreach ($routeCollection as $value) {
            $routes_list[] = Str::lower($value->uri());
        }

        //store all permission into permission table
        foreach ($routes_list as $route)
        {
            $permission_exists = Permission::where('route_url','=',$route)->exists();
            if(!$permission_exists){
                $model = new Permission();
                $model->title = $route;
                $model->route_url = $route;
                $model->description = $route;
                DB::beginTransaction();
                try {
                    $model->save();
                    DB::commit();
                    #UserLogFileHelper::log_info('route-insert-in-permission', 'Successfully insert', ['Permission id: '.$model->route_url]);
                    Session::flash('message', "Route : ".$route. " is successfully added.");

                } catch(\Exception $e) {
                    DB::rollback();
                    #UserLogFileHelper::log_error('route-insert-in-permission', $e->getMessage(), ['Permission id: '.$model->route_url]);
                    Session::flash('danger',$e->getMessage());

                }

                //set data
                $action_name = 'added new permission ';
                $action_url = 'user/route-in-permission';
                $action_detail = @\Auth::user()->username.' '. 'added new permission :: '.$route;
                $action_table = 'permissions';
                //store into user_activity table
                #ActivityLogs::set_users_activity($action_name, $action_url, $action_detail, $action_table , $this->current_market_place->id, $this->local_ip);

            }
            else{
                Session::flash('info', "Route : ".$route." already exists. No new route found");
            }
        }

        return redirect()->back();



    }



}