@extends('admin::layouts.master')

@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">

            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $pageTitle }} <span style="color: #A54A7B" data-toggle="tooltip" title="we can show all user login history in this page" > (?) </span></strong></div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {!! Form::open(['method' =>'GET','route'=>'user.search.activity', 'id' => 'user_activity_search']) !!}
                            <div id="index-search">
                                <div class="col-sm-5">
                                    {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Please type your search keywords', 'title'=>'']) !!}
                                </div>
                                <div class="col-sm-4 filter-btn">
                                    {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type title then click search button for required information')) !!}

                                    <a href="{{route('user.view.activity')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <section class="panel panel-default">

            <div class="panel-body">

                <table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable1">
                    <thead>
                    <tr>
                        <th>Market Place</th>
                        <th> Email </th>
                        <th> Action </th>
                        <th> Action Url </th>
                        <th> Action Table </th>
                        <th> Action Detail </th>
                        <th> Ip Address</th>
                        <th> Date </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data))
                        @foreach($data as $values)
                            <tr class="gradeX">
                                <td>{{isset($values->relMarketPlace)?$values->relMarketPlace->title:'- no market place -'}}</td>
                                <td>{{isset($values->relUser)?$values->relUser->email:'-- no users --'}}</td>
                                <td>{{$values->action_name}}</td>
                                <td>{{$values->action_url}}</td>
                                <td>{{$values->action_table}}</td>
                                <td>{{$values->action_detail}}</td>
                                <td>{{$values->ip_address}}</td>
                                <td>{{$values->created_at}}</td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

                <br/>
                <span class="pull-left">{{ \App\Http\Helpers\CommonHelper::paginationDescription($data) }}</span>
                <br/>
                <span class="pull-left">{{ $data->appends(request()->except('page'))->links() }}</span>

            </div>

        </section>

    </div>
    <!-- End Page -->


    <script>


        $().ready(function() {

            // validate signup form on keyup and submit
            $("#user_activity_search").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 2
                    }
                },
                messages: {
                    title: {
                        required: "Please type your search keywords",
                        minlength: "Your search keywords must consist of at least 2 characters"
                    }
                }
            });

        });

    </script>

@stop