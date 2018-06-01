<?php
/**
 * Created by PhpStorm.
 * User: Mithun Adhikary
 * Date: 3/14/17
 * Time: 6:06 PM
 */
?>
@extends('admin::layouts.master')
@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $pageTitle }} <span style="color: #A54A7B" data-toggle="tooltip" title="assign user role" > (?) </span></strong></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {{-------------- Filter :Starts -------------------------------------------}}
                            {!! Form::open(['route' => 'user.search.user.role', 'method'=>'GET']) !!}

                            <div id="index-search">
                                <div class="col-sm-5">
                                    {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Please type user name', 'title'=>'Type your required Role title "title", then click "search" button']) !!}
                                </div>
                                <div class="col-sm-4 filter-btn">
                                    {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info pop','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type code or title or both in specific field then click search button for required information')) !!}

                                    <a href="{{route('user.index.role.user')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                                </div>
                            </div>


                            {!! Form::close() !!}

                            {{-------------- Filter :Ends -------------------------------------------}}


                        </div>

                    </div>


                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <a class="btn btn-w-lg btn-info pull-right pop" data-toggle="modal" href="#addData" data-placement="top" data-content="click add user role">
                            <strong>Add User Role</strong>
                        </a>

                    </div>

                </div>

            </div>
        </section>

        <section class="panel panel-default">

            <div class="panel-body">

                <div class="table-responsive">

                    {!!  Form::open(['route' => ['user.delete.all.user.role' ], 'id' => 'formCheckbox']) !!}

                    <input type="button" id="deleteBatch" class="btn btn-danger btn-xs" value="Delete Selected User Role" style="display: none;"  onclick="submitForm()" >

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="datatable1">

                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll">&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="check for select permission roles delete"></span></th>
                            <th> Role Title </th>
                            <th> User Name</th>
                            <th> Status </th>
                            <th> Action &nbsp;&nbsp;
                                <span style="color: #A54A7B " class="top-popover" rel="popover" data-title="" data-html="true" data-content="view : click for details informations<br> delete : click for delete informations"> (?) </span></th>
                        </tr>
                        </thead>

                        @if(isset($data))
                            @foreach($data as $values)

                                <tr class="gradeX">
                                    <td><input type="checkbox" name="pr_ids[]" value="{{ $values->ru_id }}"></td>
                                    <td>{{ucfirst($values->r_title)}}</td>
                                    <td>{{ucfirst($values->username)}}</td>
                                    <td>{{ucfirst($values->ru_status)}}</td>
                                    <td>
                                        <a href="#" data-href="{{ route('user.edit.role.user', $values->ru_id) }}" class="btn btn-info btn-xs open-role-user-modal" data-content="view"><i class="fa fa-edit"></i></a>

                                        <a href="{{ route('user.delete.role.user', $values->ru_id) }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('Are you sure to Delete?')" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

                    </table>

                    {!! Form::close() !!}

                    <br/>
                    <span class="pull-left">{{ \App\Http\Helpers\CommonHelper::paginationDescription($data) }}</span>
                    <br/>
                    <span class="pull-left">{!! str_replace('/?', '?', $data->render()) !!} </span>
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
                    {!! Form::open(['route' => 'user.add.user.role','id' => 'form_2', "class"=>"role-user-form" ]) !!}

                    @include('user::role_user._form')
                    {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->


    <!-- Modal  -->

    <div class="modal fade role-user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


            </div>
        </div>
    </div>
    <!-- modal -->


    <script>

        $(document).delegate('.open-role-user-modal','click',function () {

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

                    $('.role-user-modal .modal-content').html(response.content);

                    $('.role-user-modal').modal('show');
                }else{

                }
            }).fail(function( jqXHR, textStatus ) {

            });


            return false;


        });

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

        var formChanged = false;
        $(document).delegate('.role-user-form','keyup change paste', 'input, select, textarea', function(){
            formChanged = true;
        });
        $(document).delegate('.role-user-form', 'submit', function (e) {

            e.stopImmediatePropagation();

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        })
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