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
                <strong><span class="glyphicon glyphicon-th"></span> Information</strong>
                <a href="{{ route('user.edit-zogo-partnets',$data->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                <a class="btn btn-primary btn-xs pull-right" href="{{route('user.zogo-partners')}}"><span class="glyphicon glyphicon-backward"></span> Back</a>
            </div>

            <div class="panel-body">

                <p class="table_style">

                    <strong>Prefix</strong> : {{ucfirst($data->prefix_name)}}<br/>
                    <strong>User Type</strong> : {{ucfirst($data->type)}}<br/>
                    <strong>Status</strong> : {{ucfirst($data->status)}}<br/>
                    <strong>First Name</strong> : {{ucfirst($data->first_name)}}<br/>
                    <strong>Last Name</strong> : {{ucfirst($data->last_name)}}<br/>
                    <strong>Middle Name</strong> : {{ucfirst($data->middle_name)}} <br/>
                    <strong>Sr / Jr / II etc</strong> : {{ucfirst($data->suffix_name)}}<br/>
                    <strong>Phone</strong> : {{ucfirst($profile->cell_phone)}}<br/>
                    <strong>Fax</strong> : {{ucfirst($profile->fax)}}<br/>
                    <strong>Email</strong> : {{ucfirst($data->email)}}<br/>
                    <strong>Comment Box</strong> : {{ucfirst($profile->comment)}}<br/><br/>

                   
                    <strong style="color:#755c9b">Business Address</strong><br/><br/>

                    <strong>Street address</strong> : {{ucfirst($profile->business_street)}}<br/>
                    <strong>Apt, suite, etc.</strong> : {{ucfirst($profile->business_apt_suite)}}<br/>
                    <strong>City</strong> : {{ucfirst($profile->business_city)}}<br/>
                    <strong>State</strong> : {{ucfirst($profile->business_state)}}<br/>
                    <strong>Zip code</strong> : {{ucfirst($profile->business_zip)}}<br/>


                </p>

            </div>

        </div>


    </div>


@stop