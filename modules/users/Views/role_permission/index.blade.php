@extends('admin::layouts.master')
@section('content')


    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $pageTitle }} <span style="color: #A54A7B" data-toggle="tooltip" title="all user role permission define from this page, example : system-user or admin" > (?) </span></strong></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {{-------------- Filter :Starts -------------------------------------------}}
                            {!! Form::open(['route' => 'user.search.role.permission', 'method'=>'GET']) !!}

                            <div id="index-search">
                                <div class="col-sm-5">
                                    {!! Form::text('query', @Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Please type permission title', 'title'=>'Type your required Role title "title", then click "search" button']) !!}
                                </div>
                                <div class="col-sm-4 filter-btn">
                                    {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info pop','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type code or title or both in specific field then click search button for required information')) !!}

                                    <a href="{{route('user.search.role.permission')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                                </div>
                            </div>


                            {!! Form::close() !!}

                            {{-------------- Filter :Ends -------------------------------------------}}

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <a class="btn btn-w-lg btn-info pull-right pop" data-toggle="modal" href="#addData" data-placement="top" data-content="click add role permission button for new role permission entry">
                            <strong>Add Role Permission</strong>
                        </a>

                    </div>

                </div>

            </div>
        </section>



        <section class="panel panel-default">

            <div class="panel-body">

                <div class="table-responsive">


                    {!!  Form::open(['route' => ['user.delete.all.role.permission', 'id'=>0 ], 'id' => 'formCheckbox']) !!}
                    <input type="button" id="deleteBatch" class="btn btn-danger btn-xs" value="Delete Selected Permission Role" style="display: none;"  onclick="submitForm()" >

                        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable1">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll">&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="check for select permission roles delete"></span></th>
                                <th> Role Title </th>
                                <th> Permission Title</th>
                                <th> Status </th>
                                <th> Action &nbsp;&nbsp;
                                    <span style="color: #A54A7B " class="top-popover" rel="popover" data-title="" data-html="true" data-content="view : click for details informations<br> delete : click for delete informations"> (?) </span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data))
                                @foreach($data as $values)
                                    <tr class="gradeX">
                                        <td><input type="checkbox" name="pr_ids[]" value="{{ $values->id }}"></td>
                                        <td>{{ucfirst(@$values->r_title)}}</td>
                                        <td>{{ucfirst(@$values->p_title)}}</td>
                                        <td>{{ucfirst(@$values->status)}}</td>
                                        <td>
                                           {{-- <a href="{{ route('user.view.role.permission', $values->id) }}" class="btn btn-info btn-xs" data-placement="top" data-toggle="modal" data-target="#bgModal" data-content="view"><i class="fa fa-eye"></i></a>--}}

                                            <a href="{{ route('user.delete.role.permission', $values->id) }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('Are you sure to Delete?')" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>

                    {!! Form::close() !!}

                    <br/>
                    <span class="pull-left">{{ \App\Http\Helpers\CommonHelper::paginationDescription($data) }}</span>
                    <br/>
                    <span class="pull-left">{{ $data->appends(request()->except('page'))->links() }}</span>


                </div>

            </div>

        </section>

    </div>
    <!-- End page -->




    <div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Permission assign to a role<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more information </em>"> (?)</span></h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['route' => 'user.add.role.permission','id' => 'form_2', "class"=>"form form-validate floating-label",  "novalidate"=>"novalidate" ]) !!}
                   
                     @include('user::role_permission._form')
                {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->


    <!-- Modal  -->

    <div class="modal fade" id="bgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


            </div>
        </div>
    </div>
    <!-- modal -->


    <script>

        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            if($(this).prop("checked") == true){
                $("#deleteBatch").show();
            }
            else{
                $("#deleteBatch").hide();
            }
        });
        $("table input:checkbox").on('change',function(){
            if($(this).prop("checked") == true){
                $("#deleteBatch").show();
            }
        });
        function submitForm(){
            var form = document.getElementById('formCheckbox');
            var r = confirm("Are you sure about batch delete !");
            if (r == true) {
                form.submit();
            } else {
                return false;
            }
        }
    </script>

    <!--script for this page only-->
    @if($errors->any())
        <script type="text/javascript">
            $(function(){
                $("#addData").modal('show');
            });
        </script>
    @endif


@stop