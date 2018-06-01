    <!-- BEGIN BASIC VALIDATION -->
<div class="row">

    <div class="col-lg-offset-0 col-md-12">

            <div class="row">
                <div class="col-lg-offset-0 col-md-6">

                    <div class="form-group">

                        {!! Form::label('first_name','First Name') !!} <span class="required">*</span>
                        {!! Form::text('first_name', null, ['id'=>'first_name', 'class' => 'form-control', 'required'=> 'required', 'data-rule-minlength'=>"2"]) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('first_name') !!}</span>
                </div>
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">

                        {!! Form::label('last_name','Last Name') !!} <span class="required">*</span>
                        {!! Form::text('last_name', null, ['id'=>'last_name', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"2"]) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('last_name') !!}</span>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">

                        {!! Form::label('username','Username') !!} <span class="required">*</span>
                        {!! Form::text('username', null, [ 'id'=>'username', 'class' => 'form-control', 'required' => 'required'  ]) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('username') !!}</span>

                </div>
                <div class="col-lg-offset-0 col-md-6">

                    <div class="form-group">

                        {!! Form::label('email','Email') !!} <span class="required">*</span>
                        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control', 'required' => 'required']) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('email') !!}</span>

                </div>
            </div>



            {{--@if(isset($data->id))
                <label>
                    <input type="radio" name="change-option" value="1" onclick="changing_option()">
                Want to change password okokoko? </label>
            @endif--}}


            @if(!isset($data['username']))
            <div class="row" >
                <div id="password-changing-option" style=" {{ isset($data->id)? 'display: block': null }} ">

                    <div class="col-lg-offset-0 col-md-6">
                        <div class="form-group">

                            {!! Form::label('password','Password') !!} <span class="required">*</span>
                            {!! Form::password('password', ['id'=>'password', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"4"]) !!}

                        </div>
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                    </div>
                    <div class="col-lg-offset-0 col-md-6">
                        <div class="form-group">

                            {!! Form::label('confirm_password','Confirm Password') !!} <span class="required">*</span>
                            {!! Form::password('confirm_password', ['id'=>'confirm_password', 'class' => 'form-control', 'required' => 'required', 'data-rule-minlength'=>"4", 'onkeyup'=>"validation()"]) !!}


                            <span id='show-message'></span>

                        </div>
                        <span class="text-danger">{!! $errors->first('password') !!}</span>


                    </div>

                </div>

            </div>
            @endif



            <div class="row">
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">
                        <?php
                            $role= '';
                            if(isset($role_user) && count($role_user) > 0){
                                $role = $role_user->roles_id;
                            }
                        ?>
                        {!! Form::label('roles_id','User Role') !!} <span class="required">*</span>
                        <select id="roles_id" name="roles_id" class="form-control" required>

                            @if(empty($role))
                                <option>-Please select role-</option>
                            @endif
                            
                            @if(isset($roles ))
                                @foreach ($roles as $values)
                                    <option value="{{ $values['id'] }}" <?= ($values['id'] == $role)?'selected':''; ?> >
                                        {{ \Illuminate\Support\Str::upper($values['title']) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                    <span class="text-danger">{!! $errors->first('roles_id') !!}</span>
                </div>
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!} <span class="required">*</span>
                        {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['id'=>'status', 'class'=>'form-control ','required']) !!}
                    </div>
                    <span class="text-danger">{!! $errors->first('status') !!}</span>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">

                        <?php
                            $types = [
                                    'admin' => 'Admin',
                                    'marketplace' => 'Marketplace',
                                    'customer' => 'Customer',
                                    'partner' => 'Partner',
                                    'founder' => 'Founder',
                            ];
                        ?>

                        {!! Form::label('type','User Type') !!} <span class="required">*</span>
                        {!! Form::Select('type', $types, Input::old('type'),['id'=>'type', 'class'=>'form-control ','required']) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('type') !!}</span>
                </div>

                <div class="col-lg-offset-0 col-md-6">
                    <div class="form-group">


                        {!! Form::label('market_place_id','Market place') !!} <span class="required">*</span>
                        {!! Form::Select('market_place_id', $marketplaces, Input::old('market_place_id'),['id'=>'market_place_id', 'class'=>'form-control ','required']) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('market_place_id') !!}</span>
                </div>

            </div>




            <div class="form-margin-btn pull-right">

                <a href="{{route('user.lists')}}" class=" btn btn-default " data-placement="top" data-content="click close button for close this entry form">Close</a>

                {!! Form::submit('Save Changes', ['id'=>'btn-disabled','class' => 'btn btn-primary ','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}

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
        document.getElementById("password-changing-option").style.display = "block";
    }

</script>

    <script type="text/javascript">


        $().ready(function() {

            // validate signup form on keyup and submit
            $("#user_form").validate({
                ignore: "",
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2
                    },
                    last_name: {
                        required : true,
                        minlength: 2
                    },
                    username: {
                        required : true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 4
                    },
                    confirm_password: {
                        required: true,
                        minlength: 4
                    },
                    roles_id: {
                        required: true,
                        number: true
                    },
                    status: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    market_place_id: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    first_name: {
                        required: "Please enter first name",
                        minlength: "Your first name must consist of at least 2 characters"
                    },
                    last_name: {
                        required: "Please enter last name",
                        minlength: "Your last name must consist of at least 2 characters"
                    },
                    username: {
                        required: "Please enter username",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    email: {
                        required: "Please enter email"
                    },
                    password: {
                        required: "Please enter password",
                        minlength: "Your password must consist of at least 4 characters"
                    },
                    confirm_password:{
                        required: "Please enter confirm password",
                        minlength: "Your confirm password must consist of at least 4 characters"
                    }

                }
            });

        });

        var formChanged = false;
        $('#user_form').on('keyup change paste', 'input, select, textarea, .note-editable', function(){
            formChanged = true;
        });
        $(document).delegate('#user_form', 'submit', function () {

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        })
    </script>



