
    
            <div class="col-lg-offset-0 col-md-12">
                    <div class="form-group">

                         {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!} <span class="required">*</span>
                         {!! Form::text('title',Input::old('title'),['id'=>'title','class' => 'form-control','required'=> 'required','data-rule-minlength'=>'2', 'title'=>'Enter Role Name']) !!}

                    </div>
                    <span class="text-danger">{!! $errors->first('title') !!}</span>
            </div>

             <div class="col-lg-offset-0 col-md-12">
                    <div class="form-group">
                         {!! Form::label('status', 'Status') !!} <span class="required">*</span>
                       
                        {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['id'=>'status', 'class'=>'form-control ','required'=> 'required']) !!}


                    </div>
                    <span class="text-danger">{!! $errors->first('status') !!}</span>
            </div>

    <div class="row">
        <div class="col-lg-offset-0 col-md-12">
            <div class="form-margin-btn pull-right">

                <span class="btn btn-default" data-dismiss="modal" aria-label="Close" data-content="click close button for close this entry form"> Close </span>

                {!! Form::submit('Save changes', ['class' => 'btn btn-primary pull-right','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}&nbsp;

            </div>
        </div>
    </div>



