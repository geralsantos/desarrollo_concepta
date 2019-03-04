<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<form method="post" action="{{route('company.auth.login')}}">
        {!! csrf_field() !!}
    username
    <input type="text" name="username">
    contraseña
    <input type="password" name="password">
    <button type="submit">login</button>
</form>
</body>
</html>