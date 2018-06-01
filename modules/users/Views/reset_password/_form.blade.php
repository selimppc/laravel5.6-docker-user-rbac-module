<!-- Form -->
<div class="signin-form">

    {!! Form::open(['route' => 'user.reset.password']) !!}

   
    <div class="form-group">
        <label>Enter Email Address</label>
        {!! Form::email('email', null, ['class' => 'form-control','required','required'=>'required','title'=>'Enter Email Address']) !!}
    </div>

    <div class="form-actions">
        <input type="submit" value="Reset Password" class="btn btn-info bg-primary">
    </div>
    {!! Form::close() !!}
    <!-- / Form -->
</div>
