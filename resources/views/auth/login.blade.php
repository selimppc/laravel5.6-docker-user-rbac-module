@extends('layouts.app')

@section('content')

    <style>

        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
        }
    </style>

    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <p>&nbsp;</p>
            <h2 class="ui image header">
                <div class="content">
                    Log-in to your account
                </div>
            </h2>

            <p>&nbsp;</p>
            <form  method="POST" action="{{ route('login') }}" class="ui form fluid">
                {{ csrf_field() }}
                <div class="ui stacked secondary segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" placeholder="E-mail address" value="{{ old('email') }}" required autofocus>
                        </div>


                        @if ($errors->has('email'))
                                <span class="ui red message">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif


                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
                        </div>

                        @if ($errors->has('password'))
                                <span class="ui red message">
                                        <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif

                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input class="left aligned" type="checkbox" tabindex="0" name="remember" checked {{ old('remember') ? 'checked' : '' }}>
                            <label>{{ __('Remember Me') }}</label>
                        </div>
                    </div>

                    <div class="ui fluid large teal submit button"> {{ __('Login') }}</div>
                </div>

                <div class="ui error message">

                </div>

            </form>

            <div class="ui message" >
                <span class="ui left floated"> New to us?  <a href="{{ route('register') }}">Register</a></span>
                <a href="{{ route('password.request') }}" class="ui right floated" style="float: right;">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        $(document)
            .ready(function() {
                $('.ui.form')
                    .form({
                        on: 'blur',
                        fields: {
                            email: {
                                identifier  : 'email',
                                rules: [
                                    {
                                        type   : 'email',
                                        prompt : 'Please enter a valid e-mail'
                                    }
                                ]
                            },
                            password: {
                                identifier  : 'password',
                                rules: [
                                    {
                                        type   : 'empty',
                                        prompt : 'Please enter your password'
                                    }
                                ]
                            }
                        }

                    })
                ;
            })
        ;
    </script>

@endsection
