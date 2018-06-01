<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 01/06/18
 * Time: 3:45 PM
 */

Route::any('users-test', function () {
    return "WELCOME TO USERS MODULE";
});

    /*------------------------------------*/
    /*
     * User Reset Password
     */
    Route::get('user/form-reset-password', [
        'as' => 'user.form.reset.password',
        'uses' => 'UserController@reset_password_form'
    ]);
    Route::post('user/reset-password', [
        'as' => 'user.reset.password',
        'uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@reset_password'
    ]);
    Route::get('user/update-reset-password/{token}', [
        'as' => 'user.update.reset.password',
        'uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@update_reset_password'
    ]);
    Route::post('user/set-new-password}', [
        'as' => 'user.set.new.password',
        'uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@set_new_password'
    ]);




/*------------*/
// middleware
Route::Group(['namespace'=>'Modules\Users\Controllers', /*'middleware' => 'web'*/],function() {

    /*------------------------------------*/
    /*
    * Users
    */
    Route::get('admin/user/lists', [
        #'middleware' => 'acl_access:admin/user/lists',
        'as' => 'user.lists',
        'uses' => 'UserController@index'
    ]);

    Route::get('admin/user/add_new', [
        #'middleware' => 'acl_access:admin/user/add_new',
        'as' => 'user.add_new',
        'uses' => 'UserController@add_new'
    ]);


    Route::get('admin/user/delete/{id}', [
        #'middleware' => 'acl_access:admin/user/delete/{id}',
        'as' => 'user.delete',
        'uses' => 'UserController@destroy_user'
    ]);
    Route::get('admin/user/profile', [
        #'middleware' => 'acl_access:admin/user/profile',
        'as' => 'user.profile',
        'uses' => 'UserController@user_profile'
    ]);
    Route::post('admin/user/profile/image', [
        #'middleware' => 'acl_access:admin/user/profile/image',
        'as' => 'user.profile.image',
        'uses' => 'UserController@post_profile_image'
    ]);
    Route::get('admin/user/profile/edit', [
        #'middleware' => 'acl_access:admin/user/profile/edit',
        'as' => 'user.profile.edit',
        'uses' => 'UserController@edit_profile_per_user'
    ]);
    Route::any('admin/user/profile/update', [
        #'middleware' => 'acl_access:admin/user/profile/update',
        'as' => 'user.profile.update',
        'uses' => 'UserController@update_profile_per_user'
    ]);


    /*------------------------------------*/
    /*
     * User Logout
     */
    Route::any('admin/user/logout', [
        #'middleware' => 'acl_access:admin/user/logout',
        'as' => 'user.logout',
        'uses' => 'UserController@user_logout'
    ]);


    /*------------------------------------*/
    /*Role */
    Route::get('admin/user/role', [
        #'middleware' => 'acl_access:admin/user/role',
        'as' => 'user.role',
        'uses' => 'RoleController@index'
    ]);
    Route::any('admin/user/store-role', [
        #'middleware' => 'acl_access:admin/user/store-role',
        'as' => 'user.store.role',
        'uses' => 'RoleController@store_role'
    ]);
    Route::any('admin/user/view-role/{slug}', [
        #'middleware' => 'acl_access:admin/user/view-role/{slug}',
        'as' => 'user.view.role',
        'uses' => 'RoleController@show'
    ]);
    Route::any('admin/user/edit-role/{slug}', [
        #'middleware' => 'acl_access:admin/user/edit-role/{slug}',
        'as' => 'user.edit.role',
        'uses' => 'RoleController@edit'
    ]);
    Route::any('admin/user/update-role/{slug}', [
        #'middleware' => 'acl_access:admin/user/update-role/{slug}',
        'as' => 'user.update.role',
        'uses' => 'RoleController@update'
    ]);

    Route::get('admin/user/delete-role/{slug}', [
        #'middleware' => 'acl_access:admin/user/delete-role/{slug}',
        'as' => 'user.delete.role',
        'uses' => 'RoleController@destroy'
    ]);

    Route::get('admin/user/role-search', [
        #'middleware' => 'acl_access:admin/user/role-search',
        'as' => 'user.role.search',
        'uses' => 'RoleController@search_role'
    ]);


    /*------------------------------------*/
    /*Permission */
    Route::get('admin/user/permission', [
        #'middleware' => 'acl_access:admin/user/permission',
        'as' => 'user.index.permission',
        'uses' => 'PermissionController@index'
    ]);
     /* Store Permission */
    Route::any('admin/user/store-permission', [
        #'middleware' => 'acl_access:admin/user/store-permission',
        'as' => 'user.store.permission',
        'uses' => 'PermissionController@store'
    ]);
    /* View Permission */
    Route::get('admin/user/view-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/view-permission/{id}',
        'as' => 'user.view.permission',
        'uses' => 'PermissionController@show'
    ]);
    /* Edit Permission */
    Route::get('admin/user/edit-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/edit-permission/{id}',
        'as' => 'user.edit.permission',
        'uses' => 'PermissionController@edit'
    ]);
    /* Update Permission */
    Route::any('admin/user/update-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/update-permission/{id}',
        'as' => 'user.update.permission',
        'uses' => 'PermissionController@update'
    ]);
    /* Delete Permission */
    Route::get('admin/user/delete-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/delete-permission/{id}',
        'as' => 'user.delete.permission',
        'uses' => 'PermissionController@destroy'
    ]);

     /* Delete All Permission */
    Route::post('admin/user/delete-all-role-permission', [
        ##'middleware' => 'acl_access:admin/user/delete-role-permission/{id}',
        'as' => 'user.delete.all.role.permission',
        'uses' => 'RolePermissionController@destroy_all'
    ]);
    
    Route::get('admin/user/route-in-permission', [
        #'middleware' => 'acl_access:admin/user/route-in-permission',
        'as' => 'route.in.permission',
        'uses' => 'PermissionController@route_in_permission'
    ]);
    Route::get('admin/user/permission-search', [
        #'middleware' => 'acl_access:admin/user/permission-search',
        'as' => 'user.permission.search',
        'uses' => 'PermissionController@search_permission'
    ]);




    /*------------------------------------*/

    /*User Role*/

    Route::get('admin/user/role-user', [
        #'middleware' => 'acl_access:admin/user/role-user',
        'as' => 'user.index.role.user',
        'uses' => 'RoleUserController@index'
    ]);

    /* Delete User Role */
    Route::get('admin/user/delete-role-user/{id}', [
         #'middleware' => 'acl_access:admin/user/delete-role-user/{id}',
        'as' => 'user.delete.user.role',
        'uses' => 'RoleUserController@destroy'
    ]);

    /* Search User Role */
    Route::get('admin/user/search-user-role', [
        #'middleware' => 'acl_access:admin/user/search-user-role',
        'as' => 'user.search.user.role',
        'uses' => 'RoleUserController@search_user_role'
    ]);

    /* Add User Role  */
    Route::post('admin/user/add-user-role', [
        #'middleware' => 'acl_access:admin/user/add-user-role',
        'as' => 'user.add.user.role',
        'uses' => 'RoleUserController@store_role'
    ]);

    Route::any('admin/user/edit-user-role/{id}', [
        #'middleware' => 'acl_access:admin/user/edit-user-role/{id}',
        'as' => 'user.edit.role.user',
        'uses' => 'RoleUserController@edit'
    ]);

    Route::any('admin/user/update-user-role/{id}', [
        #'middleware' => 'acl_access:admin/user/update-user-role/{id}',
        'as' => 'user.add.user.role_edit',
        'uses' => 'RoleUserController@update'
    ]);

    Route::any('admin/user/delete-user-role/{id}', [
        #'middleware' => 'acl_access:admin/user/delete-user-role/{id}',
        'as' => 'user.delete.role.user',
        'uses' => 'RoleUserController@delete'
    ]);

    Route::any('admin/user/delete-all-user-role', [
        #'middleware' => 'acl_access:admin/user/delete-all-user-role',
        'as' => 'user.delete.all.user.role',
        'uses' => 'RoleUserController@delete_all'
    ]);



    /*Permission */
    Route::get('admin/user/role-permission', [
        #'middleware' => 'acl_access:admin/user/role-permission',
        'as' => 'user.index.role.permission',
        'uses' => 'RolePermissionController@index'
    ]);

    Route::post('admin/user/add-permission-role', [
        #'middleware' => 'acl_access:admin/user/add-permission-role',
        'as' => 'user.add.role.permission',
        'uses' => 'RolePermissionController@create'
    ]);

    /* Store Permission */
    Route::any('admin/user/store-role-permission', [
        #'middleware' => 'acl_access:admin/user/store-role-permission',
        'as' => 'user.store.role.permission',
        'uses' => 'RolePermissionController@store'
    ]);

    /* View Permission */
    Route::any('admin/user/view-role-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/view-role-permission/{id}',
        'as' => 'user.view.role.permission',
        'uses' => 'RolePermissionController@show'
    ]);

    /* Edit Permission */
    Route::get('admin/user/edit-role-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/edit-role-permission/{id}',
        'as' => 'user.edit.role.permission',
        'uses' => 'RolePermissionController@edit'
    ]);

    /* Update Permission */
    Route::any('admin/user/update-role-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/update-role-permission/{id}',
        'as' => 'user.update.role.permission',
        'uses' => 'RolePermissionController@update'
    ]);

    /* Delete Permission */
    Route::get('admin/user/delete-role-permission/{id}', [
        #'middleware' => 'acl_access:admin/user/delete-role-permission/{id}',
        'as' => 'user.delete.role.permission',
        'uses' => 'RolePermissionController@destroy'
    ]);

    /* search Role Permission */
    Route::get('admin/user/search-role-permission', [
        #'middleware' => 'acl_access:admin/user/search-role-permission',
        'as' => 'user.search.role.permission',
        'uses' => 'RolePermissionController@search_permission_role'
    ]);


    /*------------------------------------*/
    /* View Activity */
    Route::get('admin/user/activity', [
        #'middleware' => 'acl_access:admin/user/activity',
        'as' => 'user.view.activity',
        'uses' => 'UserActivityController@login_history'
    ]);

     Route::get('admin/user/search-activity', [
        #'middleware' => 'acl_access:admin/user/search-activity',
        'as' => 'user.search.activity',
        'uses' => 'UserActivityController@search_user_history'
    ]);


    Route::get('admin/user/change-password/{id}', [
        #'middleware' => 'acl_access:admin/user/change-password/{id}',
        'as' => 'admin.user.change.password',
        'uses' => 'UserController@change_password'
    ]);

    Route::post('admin/user/do-change-password', [
        #'middleware' => 'acl_access:admin/user/do-change-password',
        'as' => 'user.do.change.password',
        'uses' => 'UserController@do_change_password'
    ]);



    Route::post('admin/user/alter-status/{id}', [
        #'middleware' => 'acl_access:admin/user/alter-status/{id}',
        'as' => 'user.alter.status',
        'uses' => 'UserController@alter_status'
    ]);


});