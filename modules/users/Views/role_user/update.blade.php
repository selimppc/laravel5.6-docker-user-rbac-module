<?php
/**
 * Created by PhpStorm.
 * User: mithun
 * Date: 3/14/17
 * Time: 9:07 PM
 */

?>
<!-- START Header scripts -->
@include('user::scripts._header')
<!-- END Header scripts -->

<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>

<div class="modal-body">

        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['user.add.user.role_edit', $data->id] , 'class' => 'role-user-form']) !!}
        @include('user::role_user._form')
        {!! Form::close() !!}

</div>

<!-- START Footer scripts -->
@include('user::scripts._footer')
<!-- END Header scripts -->
