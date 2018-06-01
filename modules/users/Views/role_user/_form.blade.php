<?php
/**
 * Created by PhpStorm.
 * User: Mithun Adhikary
 * Date: 3/14/17
 * Time: 6:26 PM
 */

?>

<!-- BEGIN BASIC VALIDATION -->
<div class="row">

    <div class="col-lg-offset-0 col-md-12">


        <div class="col-lg-offset-0 col-md-12">
            <div class="form-group">

                {!! Form::label('roles_id','Select Role') !!} <span class="required">*</span>

                <select id="role_id" name="roles_id" class="form-control" required>

                    @if(isset($role_lists ))
                        @foreach ($role_lists as $role)
                            <option <?php if($data['roles_id'] == $role->id){ echo 'selected'; } ?> value="{{ $role->id }}">
                                {{ \Illuminate\Support\Str::upper($role->slug) }}
                            </option>
                        @endforeach
                    @endif

                </select>

            </div>
            <span class="text-danger">{!! $errors->first('roles_id') !!}</span>
        </div>

        <div class="col-lg-offset-0 col-md-12">
            <div class="form-group">

                {!! Form::label('user_id','Select User') !!} <span class="required">*</span>

                <select id="user_id" name="users_id" class="form-control" required>

                    @if(isset($user_lists ))
                        @foreach ($user_lists as $user)
                            <option <?php if($data['users_id'] == $user->id){ echo 'selected'; } ?>  value="{{ $user->id }}">
                                {{ \Illuminate\Support\Str::upper($user->username) }}
                            </option>
                        @endforeach
                    @endif

                </select>

            </div>
            <span class="text-danger">{!! $errors->first('user_id') !!}</span>
        </div>

        <div class="col-lg-offset-0 col-md-12">
            <div class="form-group">
                {!! Form::label('status', 'Status') !!} <span class="required">*</span>

                {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['id'=>'status', 'class'=>'form-control ','required'=> 'required']) !!}


            </div>
            <span class="text-danger">{!! $errors->first('status') !!}</span>
        </div>

        <p> &nbsp;&nbsp; </p>

        <div class="save-margin-btn pull-right">

            <span class="btn btn-default" data-dismiss="modal" aria-label="Close" data-content="click close button for close this entry form"> Close </span>

            {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save permission role information']) !!}

        </div>

    </div>

</div>
