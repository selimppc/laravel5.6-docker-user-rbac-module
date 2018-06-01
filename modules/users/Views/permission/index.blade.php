@extends('admin::layouts.master')


@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $pageTitle }} <span style="color: #A54A7B" data-toggle="tooltip" title="we can show all permission in this page" > (?) </span></strong></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {{-------------- Filter :Starts -------------------------------------------}}
                            {!! Form::open(['method' =>'GET','route'=>'user.permission.search', 'id' => 'user_permission_search']) !!}
                            <div id="index-search">
                                <div class="col-sm-5">
                                    {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Please type route title', 'title'=>'type your require permission "title", example :: Main, then click "search" button']) !!}
                                </div>
                                <div class="col-sm-4 filter-btn">
                                    {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type title then click search button for required information')) !!}

                                    <a href="{{route('user.index.permission')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                                </div>
                            </div>
                            {!! Form::close() !!}

                            {{-------------- Filter :Ends -------------------------------------------}}

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <a class="btn btn-w-lg btn-info pull-right pop" data-toggle="modal" href="{{ route('route.in.permission') }}" data-placement="top" data-content="click to entry all route_url in permission list" onclick="return confirm('Are you sure to Add all routes in permission list?')" >Add Routes in Permission list
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
                            <th> Route Url </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B " class="top-popover" rel="popover" data-title="" data-html="true" data-content="view : click for details informations<br>update : click for update informations<br>delete : click for delete informations"> (?) </span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{ucfirst($values->title)}}</td>
                                    <td>{{$values->route_url}}</td>
                                    <td>
                                        <a href="#" data-href="{{ route('user.view.permission', $values->id) }}" class="btn btn-info btn-xs open-permission-modal" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-href="{{ route('user.edit.permission', $values->id) }}" class="btn btn-primary btn-xs open-permission-modal" data-content="update"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('user.delete.permission', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
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

            </div>

        </section>

    </div>
    <!-- End page-->



    <div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add Permissions <span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2">(?)</font> </span></h4>
                </div>
                <div class="modal-body">
                    
                     {!! Form::open(['route' => 'user.store.permission','id' => 'user-jq-validation-form', "class"=>"form form-validate floating-label",  "novalidate"=>"novalidate" ]) !!}
                    
                     @include('user::permission._form')
                    {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->


    <!-- Modal  -->

    <div class="modal fade permission-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <!-- modal -->


    <script>

        $(document).delegate('.open-permission-modal','click',function () {

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

                    $('.permission-modal .modal-content').html(response.content);

                    $('.permission-modal').modal('show');
                }else{

                }
            }).fail(function( jqXHR, textStatus ) {

            });


            return false;


        });

        $().ready(function() {

            // validate signup form on keyup and submit
            $("#user_permission_search").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 2
                    }
                },
                messages: {
                    title: {
                        required: "Please type route title",
                        minlength: "Your route title must consist of at least 2 characters"
                    }
                }
            });

        });

        var formChanged = false;
        $(document).delegate('.permission_form','keyup change paste', 'input, select, textarea', function(){
            formChanged = true;
        });
        $(document).delegate('.permission_form', 'submit', function (e) {

            e.stopImmediatePropagation();

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        })

    </script>

@stop