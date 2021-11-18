<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PHP Crawler of News Site</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper teal darken-2">
              <a href="/" class="brand-logo" style="padding-left: 12px">PHP Media Crawler</a>
              <ul id="nav-mobile" class="right hide-on-small-only">                
                <li><a href="badges.html">Login</a></li>
                <li><a class="waves-effect waves-light btn">Sign Up</a></li>
              </ul>
            </div>
        </nav>
        <div class="container">            
            {{ $slot }}
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
                 
        @yield('footer-scripts') 

        
    </body>
</html>
