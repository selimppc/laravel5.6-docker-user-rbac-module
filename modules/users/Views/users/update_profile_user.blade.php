<!-- START Header scripts -->
    @include('user::scripts._header')
<!-- END Header scripts -->





<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">
        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user.profile.update'], 'id' => 'user-jq-validation-form', "class"=>"form form-validate floating-label",  "novalidate"=>"novalidate"]) !!}
        {!! Form::hidden('id', $data->id) !!}

            @include('user::users._form_user_profile')

        {!! Form::close() !!}
</div>





<!-- START Footer scripts -->
    @include('user::scripts._footer')
<!-- END Header scripts -->