<div class="modal-header">
    <span class="button close" data-dismiss="modal" aria-label="Close" title="click x button for close this entry form">
        ×
    </span>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">
    <div style="padding: 30px;">
        <table id="" class="table table-bordered table-hover table-striped">

            <tr>
                <th class="col-lg-4">First Name</th>
                <td>{{ isset($data->first_name)?ucfirst($data->first_name):''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Last Name</th>
                <td>{{ isset($data->last_name)?ucfirst($data->last_name):''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Username</th>
                <td>{{ isset($data->username)?ucfirst($data->username):''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Email Address</th>
                <td>{{ isset($data->email)?$data->email:'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Image</th>
                <td>{{ isset($data->thumb)?$data->thumb:'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Role</th>
                <td>{{ isset($data->role_id)?$data->role_id:'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Last Visited</th>
                <td>{{ isset($data->last_visit)?$data->last_visit:'' }}</td>
            </tr>

            <tr>
                <th class="col-lg-4">Status</th>
                <td>{{ isset($data->status)? \Illuminate\Support\Str::upper($data->status):'' }}</td>
            </tr>

        </table>
    </div>
</div>

<div class="modal-footer">
    <span class="btn btn-default" data-dismiss="modal" aria-label="Close" data-content="click close button for close this entry form"> Close </span>
</div>

<script>
    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                }, 300);
            });
</script>




