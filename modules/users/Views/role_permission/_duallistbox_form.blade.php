@if(isset($role_value))
    {!! Form::hidden('roles_id',$role_value) !!}
@endif

<div class="row">
    <div class="col-sm-5" style="background: #efefef;padding-top:10px;">
        <p><strong class="text-center"> <b> Unassigned Permission List </b> </strong></p>
        <select id="optgroup" class="form-control" size="20" multiple="multiple">
            @if(isset($not_exists_permission))
                @foreach($not_exists_permission as $values)
                    <option value="{{$values->id}}">{{$values->title}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group col-sm-2 padding-top" style="padding-top:10%">
        <button type="button" id="optgroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
        <button type="button" id="optgroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="optgroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
        <button type="button" id="optgroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
    </div>

    <div class="form-group col-sm-5" style="background: #efefef;padding-top:10px;">
        <p><strong class="text-center"> <b> Assigned Permission List </b> </strong></p>
        <select name="permissions_id[]" id="optgroup_to" class="check form-control" size="20" multiple="multiple">
            @if(isset($exists_permission))
                @foreach($exists_permission as $values)
                    <option value="{{$values->id}}">{{$values->title}}</option>
                @endforeach
            @endif
        </select>
        <span id='check-message' class="required"></span>
    </div>
</div>

<div class="form-margin-btn pull-right" >
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save information','id'=>'check-empty']) !!}
    <a href="{{route('user.index.role.permission')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>

<p> &nbsp; </p>


<script type="text/javascript">

    $(document).ready(function(){
        $("#optgroup").multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });
    });

</script>

