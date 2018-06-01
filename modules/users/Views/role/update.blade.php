
<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">

        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user.update.role', $data->slug], "class"=>"role_form"]) !!}
        @include('user::role._form')
        {!! Form::close() !!}
</div>
