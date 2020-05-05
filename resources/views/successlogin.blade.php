
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
<div class="container box" style="width: 80%">
    <h3 align="center">Zoe Financial</h3><br />

    @if(isset(Auth::user()->email))
        <div class="alert alert success-block">
            <strong>Welcome {{ Auth::user()->name }}</strong>
        </div>
    @else
        <script>window.location = "/main";</script>
    @endif

    <form action="/main/search" method="get">
        <div>
            <input type="search" name="search" class="form-control">
            <span class="form-group-btn">
                <button type="submit" class="btn btn-primary">Search</button>
            </span>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Vid</th>
            <th scope="col">Hub creation date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->vid}}</td>
                <td>{{$user->date_hub}}</td>
                <td>
                    <form method="post" action="{{ URL::to('main/edituser/'.$user->id) }}">
                        {{csrf_field()}}
                        <input type="submit" name="button" class="btn btn-primary" value="edit" />
                    </form>
                </td>
                <td>
                    <form method="post" action="{{ URL::to('/main/deleteuser/'.$user->id) }}">
                        {{csrf_field()}}
                        <input type="submit" name="button" class="btn btn-warning" value="Delete" />
                    </form>
                </td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br />
        <div class="form-group">
            <a style="padding-right: 40px" href="{{ url('/main/successlogin') }}">Home</a>
            <a style="padding-right: 40px" href="{{ url('/main/register') }}">Create User</a>
            <a href="{{ url('/main/syncContacts') }}">Sync Contact</a>
            <br /><br />
            <a href="{{ url('/main/logout') }}">Logout</a>
        </div>
</div>

</body>
</html>
