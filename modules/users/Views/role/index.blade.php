@extends('admin::layouts.master')

@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">

            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $pageTitle }} <span style="color: #A54A7B" data-toggle="tooltip" title="all user role define from this page, example : system-user or admin" > (?) </span></strong></div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {{-------------- Filter :Starts -------------------------------------------}}
                            {!! Form::open(['method' =>'GET', 'route' => 'user.role.search' , 'id' => 'user_role_search']) !!}

                            <div id="index-search">
                                <div class="col-sm-5">
                                    {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Please type role title', 'title'=>'']) !!}
                                </div>
                                <div class="col-sm-4 filter-btn">
                                    {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info pop','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type code or title or both in specific field then click search button for required information')) !!}

                                    <a href="{{route('user.role')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                                </div>
                            </div>
                            <p> &nbsp;</p>
                            <p> &nbsp;</p>

                            {!! Form::close() !!}

                            {{-------------- Filter :Ends -------------------------------------------}}

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <a class="btn btn-w-lg btn-info pull-right pop" data-toggle="modal" href="#addData" data-placement="left" data-content="click add role button for new role entry">
                            <strong>Add Role</strong>
                        </a>

                    </div>


                </div>

            </div>

        </section>



        <section class="panel panel-default">

            <div class="panel-body">

                <div class="table-responsive">

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable1">
                        <thead>
                        <tr>
                            <th> Title </th>
                            <th> Status</th>
                            <th> Action &nbsp;&nbsp;
                                <span style="color: #A54A7B " class="top-popover" rel="popover" data-title="" data-html="true" data-content="view : click for details informations<br>update : click for update informations<br>"> (?) </span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{ucfirst($values->title)}}</td>
                                    <td>{{ucfirst($values->status)}}</td>
                                    <td>
                                        <a href="#" data-href="{{ route('user.view.role', $values->slug) }}" class="btn btn-info btn-xs open-user-role-modal" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-href="{{ route('user.edit.role', $values->slug) }}" class="btn btn-primary btn-xs open-user-role-modal" data-content="update"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>

                </div>
                
                <br/>
                <span class="pull-left">{{ \App\Http\Helpers\CommonHelper::paginationDescription($data) }}</span>
                <br/>
                <span class="pull-left">{{ $data->appends(request()->except('page'))->links() }}</span>

            </div>

        </section>

    </div>
    <!-- End page-->




    <div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add Role Informatons<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2">(?)</font> </span></h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['route' => 'user.store.role', "class"=>"role_form" ]) !!}
                   
                     @include('user::role._form')
                {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->


    <!-- Modal  -->

    <div class="modal fade user-role-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


            </div>
        </div>
    </div>
    <!-- modal -->


    <!--script for this page only-->
    @if($errors->any())
        <script type="text/javascript">
            $(function(){
                $("#addData").modal('show');
            });
        </script>
    @endif

    <script>

        $().ready(function() {

            // validate signup form on keyup and submit
            $(".role_form").validate({
                ignore: "",
                rules: {
                    title: {
                        required: true,
                        minlength: 2
                    },
                    status: {
                        required : true
                    }

                },
                messages: {
                    title: {
                        required: "Please enter role title",
                        minlength: "Your role title must consist of at least 2 characters"
                    },
                    status: {
                        required: "Please select status"
                    }
                }
            });

        });

        $(document).delegate('.open-user-role-modal','click',function () {

            var url = $(this).attr('data-href');
            var id = '';

            $.ajax({
                url: url,
                method: "GET",
                data: {id:id},
                dataType: "json",
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.result == 'success'){

                    $('.user-role-modal .modal-content').html(response.content);

                    $('.user-role-modal').modal('show');
                }else{

                }
            }).fail(function( jqXHR, textStatus ) {

            });


            return false;


        });

        $(document).delegate('.open-social-icon-modal','click',function () {

            var url = $(this).attr('data-href');
            var id = '';

            $.ajax({
                url: url,
                method: "GET",
                data: {id:id},
                dataType: "json",
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.result == 'success'){

                    $('.social-icon .modal-content').html(response.content);

                    $('.social-icon').modal('show');
                }else{

                }
            }).fail(function( jqXHR, textStatus ) {

            });


            return false;


        });

        $().ready(function() {

            // validate signup form on keyup and submit
            $("#user_role_search").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 2
                    }
                },
                messages: {
                    title: {
                        required: "Please type role title",
                        minlength: "Your role title must consist of at least 2 characters"
                    }
                }
            });



        });


        var formChanged = false;
        $(document).delegate('.role_form','keyup change paste',function () {
            formChanged = true;
        });

        $(document).delegate('.role_form', 'submit', function (e) {

            e.stopImmediatePropagation();

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        })


    </script>





@stop