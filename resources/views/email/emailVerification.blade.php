<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>{{$title}}</h1>
    <p>Dear {{$fname}} {{$lname}},</p>
    <p>We have received your account registration recently. If it was you, please click 
        on the "Verify Now" button to activate your account </p>
    <br/>
    <a href="{{$activationUrl}}" class="btn btn-default">Verify Now</a>
</body>
</html>