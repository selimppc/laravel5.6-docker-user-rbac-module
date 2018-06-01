@extends('admin::layouts.master')

@section('content')

    <br/>
    <div class="col-md-2">
        @include('user::users._sidebar',['data' => $data,'active'=>'password-change'])
    </div>
    <div class="col-md-10">


        <div class="panel panel-default">

            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th"></span> Change password Information</strong>
                <a class="btn btn-primary btn-xs pull-right" href="{{URL::previous()}}"><span class="glyphicon glyphicon-backward"></span> Back</a>
            </div>

            <div class="panel-body">

                {!! Form::model($data, [ 'files'=> true, 'route'=> ['user.update-zogo-partners-password', $data->id], "class"=>" form-validate",  "novalidate"=>"novalidate"]) !!}

                    <div class="col-md-12 card" style="margin-bottom: 20px;">

                        <label>If you want to change password, please click here to below button. Automatically users get password reset link</label>

                    </div>


                    <div class="row">
                        <div class="col-lg-offset-4 col-md-10">
                            <div class="form-margin-btn">
                                {!! Form::text('tab_hash', '' ,['class' => 'form-control tab_hash_field hide']) !!}

                                @if(isset($data) && !empty($data))
                                    <a href="{{URL::previous()}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Back</a>
                                @else
                                    <a href="{{Request::fullUrl()}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Back</a>
                                @endif


                                {!! Form::submit('Click to change password', ['class' => 'btn btn-success btn-w-md','name'=>'save']) !!}

                            </div>
                        </div>
                    </div>

                {!! Form::close() !!}

            </div>

        </div>


    </div>

@stop