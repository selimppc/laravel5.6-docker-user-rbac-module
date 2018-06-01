@extends('admin::layouts.master')

@section('content')

    <div class="modal-dialog" style="margin-top:2%">
        <div class="modal-content">
            <div class="modal-header">
                         <span class="close_button" style="float: right">
                             <a href="{{URL::previous()}}" class="btn btn-primary"> <span aria-hidden="true">&times;</span> </a>
                         </span>
                <h4 class="modal-title" id="myModalLabel">
                    You are: <span style="font-weight: bold; color: #002a80; text-transform:capitalize">
                               Role
                               </span>
                </h4>
            </div>
            <div class="modal-body">
                <h3 style="color: #ad6704;">You are not authorized to perform this action! </h3>
                <div>
                    <img src="{{ URL::to('/assets/images/forbidden_anime.png') }}">
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{URL::previous()}}" class="btn btn-primary btn-lg"> Go Back </a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

@stop

