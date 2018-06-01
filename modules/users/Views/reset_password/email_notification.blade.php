<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">
    <div>
        We heard that you would like to reset your password. !<br><br>
        But don't worry! You can use the following link to reset your password:
    </div>
    <div>
        {{ URL::to('user/update-reset-password/'.$link) }}.
        <p><strong>If you don't use this link within 30 minutes, it will expire.</strong></p>
    </div>
</div>
</body>
</html>