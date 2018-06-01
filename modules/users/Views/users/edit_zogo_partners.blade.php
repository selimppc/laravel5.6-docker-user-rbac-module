@extends('admin::layouts.master')

@section('content')

    <br/>

    <div class="col-md-8 col-md-offset-2">

        <a class="btn btn-w-lg btn-success pull-right" href="{{ route('user.password-change',$data->id) }}" >
            <strong>Change Password </strong>
        </a>
        <br/>

        <div class="panel panel-default" style="margin-top: 20px;">

            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> Edit Information</strong>
                <a class="btn btn-primary btn-xs pull-right" href="{{route('user.zogo-partners')}}"><span class="glyphicon glyphicon-backward"></span> Back</a>
            </div>

            <div class="panel-body">

                {!! Form::model($data, [ 'files'=> true, 'route'=> ['user.update-zogo-partners', $data->id], "class"=>" form-validate zogo-partners-form"]) !!}

                @include('user::users._zogo_partners_form')

                {!! Form::close() !!}

            </div>

        </div>


    </div>


@stop