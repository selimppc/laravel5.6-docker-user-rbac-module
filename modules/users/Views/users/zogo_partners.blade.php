@extends('admin::layouts.master')
@section('content')

    <!-- Start page -->
    <div class="page" id="pjax_full_page">

        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> All Zogo Partner Lists <span style="color: #A54A7B" data-toggle="tooltip" title="You will able to show all users below <br> Also you can update, delete from the action column in the table" > (?) </span></strong></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="row">



                            {{-------------- Search :Starts -------------------------------------------}}
                            {!! Form::open(['method' =>'GET','route'=>'user.zogo-partners-search', 'id' => 'zogo_partners_search_form']) !!}

                            <div class="col-sm-2">
                                {!! Form::hidden('type', @Input::get('type')? Input::get('type') : null, ['class' => 'form-control','placeholder'=>'Type type','title'=>'']) !!}
                                {!! Form::text('username', @Input::get('username')? Input::get('username') : null, ['class' => 'form-control','placeholder'=>'Type username','title'=>'type your require "username" then click "search" button']) !!}

                            </div>
                            <div class="col-sm-2">
                                {!! Form::Select('status',array(''=>'Status','inactive'=>'Inactive','active'=>'Active','cancel'=>'Cancel'),@Input::get('status')? Input::get('status') : null,['class'=>'form-control', 'title'=>'select your require "status", example :: open, then click "search" button']) !!}
                            </div>
                            <div class="col-sm-4 filter-btn">
                                {!! Form::submit('Search', array('class'=>'btn btn-w-lg btn-info','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}

                                <a href="{{route('user.zogo-partners')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Reset</a>

                            </div>

                            {!! Form::close() !!}

                        </div>

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
                            <th> Email </th>
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
                                    <td> {!! $values->first_name !!} {!! $values->last_name !!} </td>
                                    <td> {!! $values->email !!} </td>
                                    <td> {!! $values->last_visit !!} </td>

                                    <td>
                                        <a href="#" data-href="{{ route('user.alter.status',$values->id) }}" class="user_active_inactive">

                                            @if($values->status == 'active')
                                                <span style="color: green;">
                                                    {{ucfirst($values->status)}}
                                                </span>
                                            @else
                                                <span style="color: red;">
                                                    {{ucfirst($values->status)}}
                                                </span>
                                            @endif

                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('user.show-zogo-partners', $values->id) }}" class="btn btn-info btn-xs" ><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('user.edit-zogo-partnets', $values->id) }}" class="btn btn-primary btn-xs" ><i class="fa fa-edit"></i></a>

                                        <a href="{{ route('user.delete', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
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

    <script>

        var formChanged = false;
        $('#zogo_partners_search_form').on('keyup change paste', 'input, select, textarea', function(){
            formChanged = true;
        });
        $(document).delegate('#zogo_partners_search_form', 'submit', function () {

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        });

        $(document).delegate('.user_active_inactive','click',function(){
            var url = $(this).attr('data-href');


            $.ajax({
                url: url,
                method: "POST",
                data: {_token: '{!! csrf_token() !!}'},
                dataType: "json",
                beforeSend: function( xhr ) {
                    $('.loader_wrap').addClass('active');
                },
                async: true,
            }).done(function( data ) {

                $('.loader_wrap').removeClass('active');

                if(data.result == 'success'){

                    toastr.success(data.message);

                }else{
                    toastr.error(data.message);
                }
                $.pjax.reload('#pjax_full_page');


            }).fail(function( jqXHR, textStatus ) {

                $('.loader_wrap').removeClass('active');
                toastr.error("Request failed: " + jqXHR.responseText);

            });

            return false;
        })

    </script>

@stop