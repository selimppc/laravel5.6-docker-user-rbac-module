@extends('admin::layouts.master')

@section('content')
    <!-- Form -->
    <div class="signup-form">

        {!! Form::open(['route' => 'user-save-new-password','id'=>'forgot-data-validation']) !!}

        <div class="signup-text">
            <span>Forgot Password</span>
        </div>
        {!! Form::hidden('id', $id, array('class'=>'form-control')) !!}
        <div class="form-group">
            {!! Form::password('password',  array('id'=>'forgot-password','class'=>'form-control input-lg','required','name'=>'password','placeholder'=>'Password')) !!}
        </div>

        <div class="form-group">
            {!! Form::password('confirm_password', array('id'=>'re-forgot-password','class'=>'form-control input-lg','required','name'=>'confirm_password','placeholder'=>'Confirm-password','onkeyup'=>"password_validation()")) !!}
            <span id='er-show-msg'></span>
        </div>

        <div class="form-actions">
            <input type="submit" value="SUBMIT" class="signup-btn bg-primary">
        </div>
    {!! Form::close() !!}
    <!-- / Form -->
    </div>

@stop

<script type="text/javascript">

    function password_validation() {

        $('#re-forgot-password').on('keyup', function () {
            if ($(this).val() == $('#forgot-password').val()) {

                $('#er-show-msg').html('');

            }
            else $('#er-show-msg').html('confirm password do not match with new password,please check.').css('color', 'red');

        });
    }

</script>