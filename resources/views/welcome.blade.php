<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    
    <title>LaraVue</title>
    <style>
        footer{
            margin-top: auto;
            background: rgb(0, 0, 0);
            text-align: center;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body class="bg-dark">
    <div id="app">
      
        <div class="container-fluid bg-dark text-white" style="margin-top:70px">
            <router-view></router-view>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    
</body>
</html>