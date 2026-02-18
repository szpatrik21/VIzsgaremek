<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Profil</title>
</head>
    @vite([
    'resources/css/profile.css',
    'resources/css/navbar.css',
])
<body>
   <x-navbar />
   <div class="class">
    <h2>Felhasználónév</h2>
    <p>Név:</p>
    <p>Email cím:</p>
    <p>Regisztráció dátuma:</p>
    <button class="yellowbutton">Hirdetés feladása</button>
    </div>
   <style>
    .Hbutton{
        padding:5px 11px;
        border-radius:4px;
        background: #209631;
    }
    .class{
        margin-left:110px;
        margin-bottom:60px;
    }
    body{
        margin:80px;
        margin-top:100px;
    }

    h3{
        margin-left:110px;
    }
   </style>

   <h3>Meghirdetett autóim:</h3>

   <div class="carbox">
<div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Koenigsegg Jesko/Jesko1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Koenigsegg Jesko</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('koenigsegg') }}">Megtekintés</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Lamborghini Aventador/aventador1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Lamborghini Aventador</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('lamborghini') }}">Megtekintés</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Koenigsegg Jesko/Jesko1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Koenigsegg Jesko</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('koenigsegg') }}">Megtekintés</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Lamborghini Aventador/aventador1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Lamborghini Aventador</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('lamborghini') }}">Megtekintés</a>
        </div>
    </div>



</body>
</html>