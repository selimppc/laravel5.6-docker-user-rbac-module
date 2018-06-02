@extends('layouts.app')

@section('content')

        <p>&nbsp;</p>
        <h2>Register</h2>


        <form class="ui form fluid segment" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <p>Let's go ahead and get you signed up.</p>
            <div class="two fields">
                <div class="field">
                    <label>{{__('First Name')}}</label>
                    <input placeholder="First Name" name="first_name" type="text" value="{{ old('first_name') }}" required autofocus>
                    @if ($errors->has('first_name'))
                        <span class="ui error message">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="field">
                    <label>{{__('Last Name')}}</label>
                    <input placeholder="Last Name" name="last_name" type="text" value="{{ old('last_name') }}"  required>
                    @if ($errors->has('last_name'))
                        <span class="ui error message">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>{{__(' Email Address')}}</label>
                <input placeholder="Email Address" name="email_address" type="text" value="{{ old('email_address') }}"  required>
                @if ($errors->has('email_address'))
                    <span class="ui error message">
                            <strong>{{ $errors->first('email_address') }}</strong>
                        </span>
                @endif
            </div>
            <div class="two fields">
                <div class="field">
                    <label> {{__('Password')}}</label>
                    <input id="password" type="password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="ui error message">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="field">
                    <label>{{__('Confirm Password')}}</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                </div>
            </div>
            <div class="inline field">
                <div class="ui checkbox">
                    <input type="checkbox" name="terms" checked>
                    <label>I agree to the Terms and Conditions</label>
                </div>
            </div>
            <div class="ui primary submit button">Submit</div>
            <div class="ui reset button">Reset</div>
            <div class="ui clear button">Clear</div>
        </form>

        <script>
            $(document)
                .ready(function() {
                    $('.ui.form')
                        .form({
                            fields: {
                                first_name: {
                                    identifier  : 'first_name',
                                    rules: [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter your First Name'
                                        }
                                    ]
                                },
                                last_name: {
                                    identifier  : 'last_name',
                                    rules: [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter your First Name'
                                        }
                                    ]
                                },
                                email_address: {
                                    identifier  : 'email_address',
                                    rules: [
                                        {
                                            type   : 'email',
                                            prompt : 'Please enter your First Name'
                                        }
                                    ]
                                },
                                password: {
                                    identifier  :   'password',
                                    rules:  [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter a password'
                                        },
                                        {
                                            type   : 'minLength[6]',
                                            prompt : 'Your password must be at least {ruleValue} characters'
                                        }
                                    ]
                                },
                                password_confirmation:  {
                                    identifier  : 'password_confirmation',
                                    rules: [
                                        {
                                            type   : 'empty',
                                            prompt : 'Please enter a password'
                                        },
                                        {
                                            type    :   'match[password]',
                                            prompt  :   'Confirm password does not match !'
                                        }
                                    ]
                                },
                                terms: {
                                    identifier: 'terms',
                                    rules: [
                                        {
                                            type   : 'checked',
                                            prompt : 'You must agree to the terms and conditions'
                                        }
                                    ]
                                }

                            },
                            inline : true,
                            on     : 'blur',
                            onSuccess: function() {
                                console.log('Success');
                                $('.ui.form').addClass('loading');
                                return true;

                            },
                            onFailure: function() {
                                console.log('Failure');
                                $('.ui.form').removeClass('loading');
                                return false;
                            }
                        })
                    ;
                })
            ;
        </script>



@endsection
