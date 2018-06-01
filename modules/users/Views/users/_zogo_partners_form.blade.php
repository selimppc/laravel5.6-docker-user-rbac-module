<div class="col-md-12 card">

    <div class="row">
        <div class="col-md-12">
            <h1 style="margin: 0;font-size: 20px;margin-bottom: 15px;font-weight: 700;">Name</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-md-2">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('prefix_name', 'Prefix.', ['class' => 'control-label']) !!}
            {!! Form::Select('Users[prefix_name]',array(''=>'Prefix','mr'=>'Mr.','mrs'=>'Mrs.','ms'=> 'M/S.'),isset($data->prefix_name)?$data->prefix_name:Input::old('Users[prefix_name]'),['id'=>'prefix_name', 'class'=>'form-control ','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[prefix_name]') !!}</span>

        </div>

        <div class="col-md-5">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('first_name', 'First Name', ['class' => 'control-label']) !!}
            {!! Form::text('Users[first_name]', isset($data->first_name)?$data->first_name:Input::old('Users[first_name]'),['id'=>'first_name','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[first_name]') !!}</span>

        </div>

        <div class="col-md-5">
            {!! Form::label('middle_name', 'M. I', ['class' => 'control-label']) !!}
            {!! Form::text('Users[middle_name]', isset($data->middle_name)?$data->middle_name:Input::old('Users[middle_name]'),['id'=>'middle_name','class' => 'form-control']) !!}
            <span class="text-danger">{!! $errors->first('Users[middle_name]') !!}</span>

        </div>


    </div>
    <br/>
    <div class="row">

        <div class="col-md-2">
            <span class="required"> &nbsp;*</span>
            <input type="hidden" name="previous_status" value="{{isset($data->status)?$data->status:''}}">
            {!! Form::label('type', 'Type', ['class' => 'control-label']) !!}
            {!! Form::Select('Users[type]',array(''=>'Select','partner'=>'Partner','founder'=>'Founder','partner-founder'=> 'Partner & Founder(both)'),isset($data->type)?$data->type:Input::old('Users[type]'),['id'=>'type', 'class'=>'form-control ','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[type]') !!}</span>
        </div>

        <div class="col-md-5">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
            {!! Form::text('Users[last_name]', isset($data->last_name)?$data->last_name:Input::old('Users[last_name]'),['id'=>'last_name','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[last_name]') !!}</span>

        </div>

        <div class="col-md-5">
            {!! Form::label('suffix_name', 'Sr / Jr / II etc.', ['class' => 'control-label']) !!}
            {!! Form::text('Users[suffix_name]', isset($data->suffix_name)?$data->suffix_name:Input::old('Users[suffix_name]'),['id'=>'suffix_name','class' => 'form-control']) !!}
            <span class="text-danger">{!! $errors->first('Users[suffix_name]') !!}</span>

        </div>


    </div>
    <br/><br/>

    <div class="row">
        <div class="col-md-12">
            <h1 style="margin: 0;font-size: 20px;margin-bottom: 15px;font-weight: 700;">Business Address</h1>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('business_street', 'Street Address', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[business_street]', isset($profile->business_street)?$profile->business_street:Input::old('UsersProfiles[business_street]'),['id'=>'business_street','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[business_street]') !!}</span>

        </div>

        <div class="col-md-6">
            {!! Form::label('business_apt_suite', 'Apt, suite, etc.', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[business_apt_suite]', isset($profile->business_apt_suite)?$profile->business_apt_suite:Input::old('UsersProfiles[business_apt_suite]'),['id'=>'business_apt_suite','class' => 'form-control']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[business_apt_suite]') !!}</span>

        </div>


    </div>
    <br/>

    <div class="row">

        <div class="col-md-4">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('business_city', 'City', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[business_city]', isset($profile->business_city)?$profile->business_city:Input::old('UsersProfiles[business_city]'),['id'=>'business_city','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[business_city]') !!}</span>

        </div>

        <div class="col-md-4">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('business_state', 'State', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[business_state]', isset($profile->business_state)?$profile->business_state:Input::old('UsersProfiles[business_state]'),['id'=>'business_state','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[business_state]') !!}</span>

        </div>

        <div class="col-md-4">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('business_zip', 'Zip code', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[business_zip]', isset($profile->business_zip)?$profile->business_zip:Input::old('UsersProfiles[business_zip]'),['id'=>'business_zip','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[business_zip]') !!}</span>

        </div>


    </div>

    <br/>
    <div class="row">

        <div class="col-md-4">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('cell_phone', 'Phone', ['class' => 'control-label']) !!}
            {!! Form::number('UsersProfiles[cell_phone]', isset($profile->cell_phone)?$profile->cell_phone:Input::old('UsersProfiles[cell_phone]'),['id'=>'cell_phone','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[cell_phone]') !!}</span>

        </div>

        <div class="col-md-4">
            {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[fax]', isset($profile->fax)?$profile->fax:Input::old('UsersProfiles[fax]'),['id'=>'fax','class' => 'form-control']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[fax]') !!}</span>

        </div>

        <div class="col-md-4">
            {!! Form::label('tax_id', 'TAX ID', ['class' => 'control-label']) !!}
            {!! Form::text('UsersProfiles[tax_id]', isset($profile->tax_id)?$profile->tax_id:Input::old('UsersProfiles[tax_id]'),['id'=>'tax_id','class' => 'form-control']) !!}
            <span class="text-danger">{!! $errors->first('UsersProfiles[tax_id]') !!}</span>

        </div>



    </div>

    <br/>
    <div class="row">

        <div class="col-md-8">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            {!! Form::email('Users[email]', isset($data->email)?$data->email:Input::old('Users[email]'),['id'=>'email','class' => 'form-control','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[email]') !!}</span>

        </div>

        <div class="col-md-4">
            <span class="required"> &nbsp;*</span>
            {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
            {!! Form::Select('Users[status]',array(''=>'Select','active'=>'Active','inactive'=>'Inactive','cancel'=> 'Cancel'),isset($data->status)?$data->status:Input::old('Users[status]'),['id'=>'status', 'class'=>'form-control ','required']) !!}
            <span class="text-danger">{!! $errors->first('Users[status]') !!}</span>
        </div>

    </div>

    <br/>
    <div class="row">

        <div class="col-md-12">
            {!! Form::label('comment', 'Comment', ['class' => 'control-label']) !!}
            {!! Form::textarea('UsersProfiles[comment]', isset($profile->comment)?$profile->comment:Input::old('UsersProfiles[comment]'),['id'=>'comment','class' => 'form-control']) !!}
            <span comment="text-danger">{!! $errors->first('UsersProfiles[comment]') !!}</span>

        </div>



    </div>
    <br/>
    <div class="row">
        <div class="col-lg-offset-4 col-md-10">
            <div class="form-margin-btn">
                {!! Form::text('tab_hash', '' ,['class' => 'form-control tab_hash_field hide']) !!}

                @if(isset($data) && !empty($data))
                    <a href="{{URL::previous()}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                @else
                    <a href="{{Request::fullUrl()}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                @endif


                {!! Form::submit('Save', ['class' => 'btn btn-success btn-w-md','name'=>'save']) !!}

            </div>
        </div>
    </div>

</div>

<script type="text/javascript">


    var formChanged = false;
    $('.zogo-partners-form').on('keyup change paste', 'input, select, textarea, .note-editable', function(){
        formChanged = true;
    });
    $(document).delegate('.zogo-partners-form', 'submit', function () {

        if(!formChanged){
            bootbox.alert('You haven\'t changed any value yet.');
            return false;
        }

        return true;
    })
</script>