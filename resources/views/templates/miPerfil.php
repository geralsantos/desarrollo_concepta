<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<p>HOla</p>
</body>
</html>

@elseif(auth()->guard('web')->check())
				     <a class="dropdown-item" href="{{route('admin.config.user',\Illuminate\Support\Facades\Auth::web()->id)}}">{{auth()->user()->id}}</a>







				     <!-- @elseif(auth()->guard('web')->check())
				        		<a class="dropdown-item" href="{{route('admin.config.user',\Illuminate\Support\Facades\Auth::web()->id)}}">{{auth()->user()->id}}</a> -->