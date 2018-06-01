@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('flash_message_error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('flash_message_error') }}</p>
    </div>
@endif


<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user-signup.update_password', $data->id]]) !!}
            @include('user.user_info.update_password')
            {!! Form::close() !!}

        </div>
    </div>
</div>