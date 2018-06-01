<!-- BEGIN BASIC VALIDATION -->
<div class="row">

    <div class="col-lg-offset-0 col-md-12">

            <div class="row">
                <div class="col-lg-offset-0 col-md-6">

                    <div class="form-group">
                        {!! Form::text('first_name', null, ['id'=>'first_name', 'class' => 'form-control', 'required'=> 'required', 'data-rule-minlength'=>"2"]) !!}
                        {!! Form::label('first_name','First Name: *') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('first_name') !!}</span>
                </div>
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">
                        {!! Form::text('last_name', null, ['id'=>'last_name', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"2"]) !!}
                        {!! Form::label('last_name','Last Name: *') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('last_name') !!}</span>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">
                        {!! Form::email('username', null, [ 'id'=>'username', 'class' => 'form-control', 'required' => 'required'  ]) !!}
                        {!! Form::label('username','Username : *') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('username') !!}</span>

                </div>
                <div class="col-lg-offset-0 col-md-6">

                    <div class="form-group">
                        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'required' => 'required']) !!}
                        {!! Form::label('email','Email: *') !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('email') !!}</span>

                </div>
            </div>



            @if(isset($data->id))
                <label>
                    <input type="radio" name="change-option" value="1" onclick="changing_option()">
                Want to change password ? </label>
            @endif

            <div class="row" >
                <div id="password-changing-option" style=" {{ isset($data->id)? 'display: none': null }} ">

                    <div class="col-lg-offset-0 col-md-6">
                        <div class="form-group">
                            {!! Form::password('password', ['id'=>'password', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"4"]) !!}
                            {!! Form::label('password','Password : *') !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                    </div>
                    <div class="col-lg-offset-0 col-md-6">
                        <div class="form-group">
                            {!! Form::password('confirm_password', ['id'=>'confirm_password', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"4", 'onkeyup'=>"validation()"]) !!}
                            {!! Form::label('confirm_password','Confirm Password : *') !!}

                            <span id='show-message'></span>

                        </div>
                        <span class="text-danger">{!! $errors->first('password') !!}</span>


                    </div>

                </div>

            </div>


            <div class="form-margin-btn pull-right">
                {!! Form::submit('Save Changes', ['id'=>'btn-disabled','class' => 'btn btn-primary ','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}
                <a href="{{route('user.lists')}}" class=" btn btn-default " data-placement="top" data-content="click close button for close this entry form">Close</a>
            </div>


    </div><!--end .col -->
</div><!--end .row -->
<!-- END BASIC VALIDATION -->

<script>

    function validation()
    {
        $('#confirm_password').on('keyup', function () {
            if ($(this).val() == $('#password').val())
            {
                $('#show-message').html('');
                document.getElementById("btn-disabled").disabled = false;
                return false;
            }
            else
            {
                $('#show-message').html('Do not match with password.').css('color', 'red');
                document.getElementById("btn-disabled").disabled = true;
            }
        });
    }

    function changing_option()
    {
        var display_val = document.getElementById("password-changing-option").style.cssText;

        if(display_val == "display: block;"){
            document.getElementById("password-changing-option").style.display = "none";
        }else{
            document.getElementById("password-changing-option").style.display = "block";
        }

    }

</script>



