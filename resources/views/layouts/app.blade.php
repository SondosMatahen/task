<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task | Sondos</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Fonts -->
  <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <nav class="navbar navbar-default" id="nav">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <img id="img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8pr4x-NQnryYxxu6QeHTq0NAWnJ-RRkJLbw&usqp=CAU" 
        style="height:40px; margin-top:5px;"/>
          <iron-icon icon="vaadin:pencil"></iron-icon>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li>
            <a href="{{ url('/') }}" id="home">Home</a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
          <li>
            <a href="{{ url('/auth/login') }}">Login</a>
          </li>
          <li>
            <a href="{{ url('/auth/register') }}">Register</a>
          </li>
          @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              @if (Auth::user()->can_post())
              <li>
                <a href="{{ url('/new-post') }}">Add new post</a>
              </li>
              <li>
                <a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a>
              </li>
              @endif
              <li>
                <a href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
              </li>
              <li>
                <a href="{{ url('/logout') }}">Logout</a>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    @if (Session::has('message'))
    <div class="flash alert-info">
      <p class="panel-body">
        {{ Session::get('message') }}
      </p>
    </div>
    @endif
    @if ($errors->any())
    <div class='flash alert-danger'>
      <ul class="panel-body">
        @foreach ( $errors->all() as $error )
        <li>
          {{ $error }}
        </li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgb(184, 167, 189);">
            <h2>@yield('title')</h2>
            @yield('title-meta')
          </div>
          <div class="panel-body">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
       
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>

</html>