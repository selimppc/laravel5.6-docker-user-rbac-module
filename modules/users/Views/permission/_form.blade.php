
<div class="col-lg-offset-0 col-md-12">
    <div class="form-group">

        {!! Form::label('title', 'Title: *', ['class' => 'control-label']) !!}

        {!! Form::text('title',Input::old('title'), ['id'=>'title', 'class' => 'form-control','required'=>'required','data-rule-minlength'=>"3",'style'=>'text-transform:capitalize','title'=>'enter permission title, example :: Branch Permission']) !!}

    </div>
    <span class="text-danger">{!! $errors->first('title') !!}</span>
</div>


<div class="col-lg-offset-0 col-md-12">
    <div class="form-group">

        {!! Form::label('route_url', 'Route Url:', ['class' => 'control-label']) !!}

        {!! Form::text('route_url', Input::old('route_url'), ['id'=>'route_url', 'class' => 'form-control','size' => '12x3','title'=>'enter route_url about permission']) !!}

    </div>
    <span class="text-danger">{!! $errors->first('route_url') !!}</span>
</div>




<div class="row">
    <div class="col-lg-offset-0 col-md-12">
        <div class="form-margin-btn pull-right">

            <span class="btn btn-default" data-dismiss="modal" aria-label="Close" data-content="click close button for close this entry form"> Close </span>

                {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save branch information']) !!}

        </div>
    </div>
</div>


