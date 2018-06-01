@extends('admin::layouts.master')

@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> My Profile</strong></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-6 col-sm-6 col-xs-12">


                            <img class="img-circle border-white border-xl img-responsive auto-width" src="{{ asset( isset($user->thumb)? $user->thumb : 'uploads/users/default_thumb.png') }}" alt="{!! @$user->last_name !!}" />

                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#profile-picture">
                                Change Profile Image
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="profile-picture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="text-shadow: none;">
                                <div class="modal-dialog" role="document">

                                    {!! Form::open(['route' => 'user.profile.image', 'enctype'=>"multipart/form-data", 'files'=>true, "class"=>"form form-validate floating-label",  "novalidate"=>"novalidate" ]) !!}

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Profile Picture</h4>
                                        </div>
                                        <div class="modal-body">
                                            @if(isset($user->thumb))
                                                <img src="{{ asset($user->thumb) }}">
                                            @else
                                                {{ "No Image Found" }}
                                            @endif


                                            {!! Form::file('image', array('class' => 'form-control')) !!}


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>


                        <h3>
                            {!! @$user->last_name !!} <br/>
                            <small> {!! @$user->email !!}</small>
                        </h3>


                    </div>


                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <div class="width-3 text-center pull-right">
                            <strong class="text-xl">643</strong><br/>
                            <span class="text-light opacity-75">Quotes</span>
                        </div>

                    </div>


                </div>

            </div>
        </section>


        <section class="panel panel-default">

            <div class="panel-body">

                <div class="col-md-8">
                    <h2>Timeline</h2>

                    <!-- BEGIN ENTER MESSAGE -->

                    <div class="body-container">

                            My Profile Page

                    </div>



                    <!-- BEGIN ENTER MESSAGE -->

                </div><!--end .col -->

                <div class="col-md-4">

                    <div class="card card-underline style-default-dark">
                        <div class="card-head">
                            <header class="opacity-75"><small>Personal info</small></header>
                            <div class="tools">
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-icon-toggle ink-reaction " data-toggle="modal" data-target="#bgModal" ><i class="md md-edit"></i></a>


                            </div><!--end .tools -->
                        </div><!--end .card-head -->
                        <div class="card-body no-padding">
                            <ul class="list">
                                <li class="tile">
                                    <a class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <i class="md md-location-on"></i>
                                        </div>
                                        <div class="tile-text">
                                            621 Johnson Ave, Suite 600
                                            <small>Street</small>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </div><!--end .card-body -->
                    </div><!--end .card -->

                </div>

            </div>

        </section>

    </div>
    <!-- End page -->




    <!-- Modal  -->

    <div class="modal fade" id="bgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="z-index:1050">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <!-- modal -->


    <!--script for this page only-->
    @if($errors->any())
        <script type="text/javascript">
            $(function(){
                $("#bgModal").modal('show');
            });

        </script>
    @endif


@stop