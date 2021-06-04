<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    
    <title>LaraVue</title>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <router-link class="navbar-brand" to="/">Navbar</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <router-link class="nav-link" to="#">Home <span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" to="/login">Link</router-link>
                </li>
                <li class="nav-item dropdown">
                  <router-link class="nav-link dropdown-toggle" to="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                  </router-link>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <router-link class="dropdown-item" to="#">Action</router-link>
                    <router-link class="dropdown-item" to="#">Another action</router-link>
                    <div class="dropdown-divider"></div>
                    <router-link class="dropdown-item" to="#">Something else here</router-link>
                  </div>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link disabled" to="#">Disabled</router-link>
                </li>
              </ul>
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>
        <div class="container-fluid" style="margin-top:70px">
            <router-view></router-view>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    
    
</body>
</html>