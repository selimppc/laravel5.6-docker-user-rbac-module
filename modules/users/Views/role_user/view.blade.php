<?php
/**
 * Created by PhpStorm.
 * User: Mithun Adhikary
 * Date: 3/14/17
 * Time: 8:57 PM
 */
?>

<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
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
    <a href="{{route('user.index.permission')}}" class="btn btn-default" type="button" data-placement="top" data-content="click close button for close this entry form"> Close </a>
</div>

