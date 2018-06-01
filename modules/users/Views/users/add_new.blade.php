@extends('admin::layouts.master')

@section('content')
    <br/>

    <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-default">

            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> {{$pageTitle}}</strong>
                <a href="{{ url()->previous() }}" class="white-font-color pull-right">Back</a>
            </div>
            <div class="panel-body">

                {!! Form::open(['route' => 'user.store', 'id' => 'user_form', "class"=>"" ]) !!}

                    @include('user::users._form')

                {!! Form::close() !!}


            </div>

        </div>

    </div>


@stop