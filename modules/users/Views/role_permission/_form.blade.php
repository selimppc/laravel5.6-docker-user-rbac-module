<!-- BEGIN BASIC VALIDATION -->
<div class="row">

    <div class="col-lg-offset-0 col-md-12">
 
             <div class="col-lg-offset-0 col-md-12">
                <div class="form-group">

                    {!! Form::label('roles_id','Select Role : *') !!}

                    <select id="roles_id" name="roles_id" class="form-control" required>

                            @if(isset($role_lists ))
                                @foreach ($role_lists as $role)
                                    <option value="{{ $role->id }}">
                                        {{ \Illuminate\Support\Str::upper($role->slug) }}
                                    </option>
                                @endforeach
                            @endif

                    </select>

                </div>
                <span class="text-danger">{!! $errors->first('roles_id') !!}</span>
            </div>

            {!! Form::hidden('status','active') !!}
            


        <p> &nbsp;&nbsp; </p>

        <div class="save-margin-btn pull-right">
            {!! Form::submit('Next', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save permission role information']) !!}
            <a href="{{route('user.index.role.permission')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
        </div>




    </div><!--end .col -->
</div><!--end .row -->
<!-- END BASIC VALIDATION -->

