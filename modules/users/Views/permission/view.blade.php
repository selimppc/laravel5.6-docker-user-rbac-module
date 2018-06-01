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
                <th class="col-lg-4">Title</th>
                <td>{{ isset($data->title)?ucfirst($data->title):''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Route Url</th>
                <td>{{ isset($data->route_url)? $data->route_url:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Description</th>
                <td>{{ isset($data->description)?$data->description:''}}</td>
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
