@extends('admin::layouts.master')
@section('content')

    <!-- page start-->
    <div class="row" style="font-size: 13px">
        <div class="col-sm-12">
            <div class="panel">

                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;
                    <span style="color: #A54A7B " class="top-popover" rel="popover" data-title=" {{ $pageTitle }}" data-html="true" data-content="<em>we can show all permission in this page</em>"> </span>

                </div>

                <div class="panel-body">

                    <div class="col-md-12 col-sm-12">
                        <p> Here you will be able to assign permission for each and every actions in our system</p>
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['route' => 'user.store.role.permission','class' => 'role-permission-form']) !!}
                                @include('user::role_permission._duallistbox_form')
                                {!! Form::close() !!}
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div><!--end .col -->

                </div>

            </div>
        </div>
    </div>
    <!-- page end -->


    <script>
        var formChanged = false;
        $(document).delegate('.role-permission-form','keyup change paste', 'input, select, textarea', function(){
            formChanged = true;
        });
        $(document).delegate('.role-permission-form', 'submit', function (e) {

            e.stopImmediatePropagation();

            if(!formChanged){
                bootbox.alert('You haven\'t changed any value yet.');
                return false;
            }

            return true;
        })
    </script>

@stop