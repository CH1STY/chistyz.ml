<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Chistyz</title>
    <style>
        body{
            margin-bottom: 5px;
        }
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
        <div class="bg-dark text-white" style="margin-top:70px">
            <router-view></router-view>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    
</body>
</html>