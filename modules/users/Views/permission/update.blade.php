<div class="modal-header">
    <span class="button close" data-dismiss="modal" aria-label="Close" title="click x button for close this entry form">
        ×
    </span>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>

<div class="modal-body">

        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user.update.permission', $data->id], 'id' => '', "class"=>"permission_form"]) !!}

        @include('user::permission._form')

        {!! Form::close() !!}
</div>
