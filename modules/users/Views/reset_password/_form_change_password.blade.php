<!-- Form -->
<div class="signup-form">

    {!! Form::open(['route' => 'user.set.new.password', 'id'=>'reset-new-data-validation']) !!}
    {!! Form::hidden('id',$id) !!}

    <div class="signup-text">
        <span>Reset Password</span>
    </div>

    <div class="form-group">
        {!! Form::password('password',['id'=>'new-reset-pass','class' => 'form-control','placeholder'=>'New Password','required','name'=>'password','title'=>'Enter your password at least 3 characters.','minlength'=>'3']) !!}
    </div>


    <div class="form-group">
        {!! Form::password('confirm_password', array('class'=>'form-control input-lg','required','id'=>'retype-password','name'=>'confirm_password','placeholder'=>'Confirm-password','title'=>'Enter your confirm password that must be match with password.','minlength'=>'3','onkeyup'=>"validation()")) !!}
        <span id='view-msg'></span>
    </div>

    <div class="form-actions">
        <input type="submit" value="SUBMIT" class="signup-btn bg-primary">
    </div>
{!! Form::close() !!}
<!-- / Form -->
</div>

<script type="text/javascript">

    function validation() {

        $('#retype-password').on('keyup', function () {
            if ($(this).val() == $('#new-reset-pass').val()) {
                $('#view-msg').html('');
            } else $('#view-msg').html('confirm password do not match with new password,please check.').css('color', 'red');
        });
    }

</script>