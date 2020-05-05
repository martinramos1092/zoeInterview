
<!DOCTYPE html>
<html>
<head>
    <title>Simple Login System in Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .box{
            width:600px;
            margin:0 auto;
            border:1px solid #ccc;
        }
    </style>
</head>
<body>
<br />
<div class="container box">
    <h3 align="center">Registration page</h3><br />

    <form method="post" action="{{ URL::to('/main/successregistration') }}">
        <div class="form-group">
            <label>Enter name</label>
            <input type="text" name="name" class="form-control" />
        </div>
        <div class="form-group">
            <label>Enter Last ame</label>
            <input type="text" name="lastname" class="form-control" />
        </div>
        <div class="form-group">
            <label>Enter email</label>
            <input type="email" name="email" class="form-control" />
        </div>
        <div class="form-group">
            <label>Enter Password</label>
            <input type="password" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <input type="hidden" name="_token" class="form-control" value="{{csrf_token()}}"/>
        </div>
        <div class="form-group">
            <input type="submit" name="button" class="btn btn-primary" value="Register" />
        </div>
    </form>
</div>
</body>
</html>

