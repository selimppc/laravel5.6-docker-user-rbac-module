
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


                {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user.update', $data->id], 'id' => 'user_form', "class"=>""]) !!}

                    {!! Form::hidden('id', $data->id) !!}

                @include('user::users._form')

                {!! Form::close() !!}


            </div>

        </div>

    </div>

    <!-- START Footer scripts -->
    @include('user::scripts._footer')
    <!-- END Header scripts -->


@stop



