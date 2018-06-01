@extends('admin::layouts.master')
@section('content')

    <!-- Start page -->
    <div class="page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> All Users <span style="color: #A54A7B" data-toggle="tooltip" title="You will able to show all users below <br> Also you can add user, update, delete from the action column in the table" > (?) </span></strong></div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">

                        <div class="row">

                            {{-------------- Search :Starts -------------------------------------------}}
                            {!! Form::open(['method' =>'GET','route'=>'user.search', 'id' => 'all_users_search_form']) !!}

                            <div class="col-sm-4">
                                {!! Form::text('username', @Input::get('username')? Input::get('username') : null, ['class' => 'form-control','placeholder'=>'Type username','title'=>'type your require "username" then click "search" button']) !!}

                            </div>
                            <div class="col-sm-4">
                                {!! Form::Select('status',array(''=>'Status','inactive'=>'Inactive','active'=>'Active','cancel'=>'Cancel'),@Input::get('status')? Input::get('status') : null,['class'=>'form-control', 'title'=>'select your require "status", example :: open, then click "search" button']) !!}
                            </div>
                            <div class="col-sm-4 filter-btn">
                                {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}

                                <a href="{{route('user.lists')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                            </div>

                            {!! Form::close() !!}

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">

                        <a class="btn btn-w-lg btn-info pull-right pop" href="{{route('user.add_new')}}" data-content="click 'add user' button to create a new user">
                            <strong>Add User</strong>
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

                        <th> Image </th>
                        <th> Name </th>
                        <th> Username </th>
                        <th> Email </th>
                        <th> Role </th>
                        <th> Last Visit </th>
                        <th> Status &nbsp;&nbsp;<span style="color: #A54A7B" class="top-popover" rel="popover"  data-content="User's Status" > (?)</span></th>

                        <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="top-popover" rel="popover"  data-content="view : click for details informations<br>update : click for update information <br> delete : click for delete informations">
                                        (?)
                                    </span></th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td> <img style="width: 100px" src="{!! isset($values->thumb) ? asset($values->thumb) : asset('uploads/users/default_thumb.png') !!}" ></td>
                                    <td> {!! @$values->first_name !!} {!! @$values->last_name !!} </td>
                                    <td> {!! @$values->username !!} </td>
                                    <td> {!! @$values->email !!} </td>
                                    <td>
                                        @if(!empty($values->relRole))

                                            @foreach($values->relRole as $role)
                                                {{$role->title}}
                                            @endforeach

                                        @else
                                            role not assign
                                        @endif
                                    </td>

                                    <td> {!! @$values->last_visit !!} </td>

                                    <td> {{ucfirst(@$values->status)}} </td>

                                    <td>
                                        <a href="#" data-href="{{ route('user.show', $values->id) }}" class="btn btn-info btn-xs open-user-lists-modal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('user.edit', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-content="update"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('user.delete', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                        <a href="{{ route('admin.user.change.password', $values->id) }}" class="btn btn-warning btn-xs" >Change Password</a>
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
                <span class="pull-left">
                    {!! str_replace('/?', '?',  $data->appends(Input::except('page'))->render() ) !!}
                </span>

            </div>
        </section>

    </div>
    <!-- End page -->





<!-- Modal  -->

<div class="modal fade user-lists-modal" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="z-index:1050">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- modal -->

<script>

    $(document).delegate('.open-user-lists-modal','click',function () {

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

                $('.user-lists-modal .modal-content').html(response.content);

                $('.user-lists-modal').modal('show');
            }else{

            }
        }).fail(function( jqXHR, textStatus ) {

        });


        return false;


    });

    var formChanged = false;
    $('#all_users_search_form').on('keyup change paste', 'input, select, textarea', function(){
        formChanged = true;
    });
    $(document).delegate('#all_users_search_form', 'submit', function () {

        if(!formChanged){
            bootbox.alert('You haven\'t changed any value yet.');
            return false;
        }

        return true;
    })

</script>

@stop