<div class="customer_menu">
    <ul>
        <li class="{{ (isset($active) && $active == 'show')?'active':'' }}">
            <a href="{{ route('user.show-zogo-partners',$data->id) }}">Account Information</a>
        </li>
        <li class="{{ (isset($active) && $active == 'password-change')?'active':'' }}">
            <a href="{{ route('user.password-change',$data->id) }}">Change Password</a>
        </li>

    </ul>
</div>


<style type="text/css">
    .card{
        background: #fff;
        border: 1px solid rgba(0,0,0,0.2);
        padding: 15px;
    }
    .customer_menu{
        background: #fff;
        border: 1px solid rgba(0,0,0,0.2);
    }
    .customer_menu ul{
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .customer_menu ul li{
        width: 100%;
    }
    .customer_menu ul li a{
        padding: 10px 20px;
        display: block;
        border-bottom: 1px solid rgba(179, 178, 178, 0.1);
    }
    .customer_menu ul li a:hover{
        background: #BDF0FB;
    }
    .customer_menu ul li.active a{
        background: #BDF0FB;
    }
    .customer_form label{
        float: right;
        font-weight: 500;
        width: calc(100% - 10px);
        text-align: right;
    }
    .customer_form .required {
        float: right;
        font-weight: 500;
        width: 10px;
        text-align: right;
    }
    .customer_form .help-block{
        color: red;
    }

</style>