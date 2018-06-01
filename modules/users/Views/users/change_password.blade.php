@extends('admin::layouts.master')

@section('content')
<br/>
    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> Password changed of {{$data->email}}</strong>
                <a class="btn btn-primary btn-xs pull-right" href="{{URL::previous()}}"><span class="glyphicon glyphicon-backward"></span> Back</a>
            </div>

            <div class="panel-body">

                <?php
                $url = route('user.do.change.password');
                ?>
                {!! Form::open(array('url' => $url, 'method' => 'post', 'id' => "")) !!}


                    <div class="col-md-10 col-md-offset-1">

                        <input type="hidden" name="user_id" value="{{$data->id}}">
                        <div class="col-md-6">
                            <div class="register-box">
                                {!! Form::label('password','New password: *') !!}
                                {!! Form::password('password',['id'=>'password', 'class' => 'form-control','placeholder'=>'New password' ,'required']) !!}
                                <span class="text-danger">{!! $errors->first('password') !!}</span><br/>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="register-box">

                                {!! Form::label('password_confirmation','Confirm new password: *') !!}
                                {!! Form::password('password_confirmation',['id'=>'password_confirmation', 'class' => 'form-control','placeholder'=>'Confirm new password', 'required']) !!}
                                <span class="text-danger">{!! $errors->first('password_confirmation') !!}</span><br/>

                            </div>
                        </div>

                        <div class="col-md-6 pull-right">

                            <div style="text-align: right" class="register-button">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Back</a>
                                <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                <br/><br/>
                            </div>

                        </div>

                    </div>


                {!! Form::close() !!}

            </div>

        </div>

    </div>

@stop