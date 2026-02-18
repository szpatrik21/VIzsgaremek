<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    @vite([
        'resources/css/style4.css'
    ])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Autók</title>
</head>
<body>

<x-navbar />

<h2 class=autocim>Autók:</h2>

<!-- ===================== 1. sor ===================== -->
<div class="carbox">

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Koenigsegg Jesko/Jesko1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Koenigsegg Jesko</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('koenigsegg') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Lamborghini Aventador/aventador1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Lamborghini Aventador</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('lamborghini') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Lotus Evija/Lotus2.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Lotus Evija</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('lotus') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Lexus  LC 500/lexus2.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Lexus LC 500</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('lexus') }}">Érdekel</a>
        </div>
    </div>

</div>



<!-- ===================== 2. sor ===================== -->
<div class="carbox">

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Maserati MC20/Maserati.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Maserati MC20</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('maserati') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Maybach S680/Maybach1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Maybach S680</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('maybach') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/McLaren 720S/Mclaren1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>McLaren 720S</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('mclaren') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Mercedes-Benz AMG GT Black Series/AMG2.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Mercedes Benz AMG GT Black Series</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('rollsroyce') }}">Érdekel</a>
        </div>
    </div>

</div>



<!-- ===================== 3. sor ===================== -->
<div class="carbox">

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Alfa Romeo Giulia Quadrifoglio/Alfa1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Alfa Romeo Giulia Quadrifoglio</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('alfaromeo') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Aston Martin DB11/Aston1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Aston Martin DB11</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('astonmartin') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Audi R8 V10 Performance/R81.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Audi R8 V10 Performance</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('audir8') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Bentley Continental GT/GT1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Bentley Continental GT</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('bentleycontinental') }}">Érdekel</a>
        </div>
    </div>

</div>



<!-- ===================== 4. sor ===================== -->
<div class="carbox">

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/BMW M8 Competition/bmw1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>BMW M8 Competition</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('bmwm8') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Bugatti Chiron/Chiron1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Bugatti Chiron</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('bugattichiron') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Ferrari LaFerrari/laferrari1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Ferrari LaFerrari</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('ferrarilaferrari') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Jaguar F Type R/Jaguar.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Jaguar F Type R</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('jaguarf') }}">Érdekel</a>
        </div>
    </div>

</div>



<!-- ===================== 5. sor ===================== -->
<div class="carbox">

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Pagani Huayra/Pagani1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Pagani Huayra</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('pagani') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Porsche 911 Turbo S/Porsche1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Porsche 911 Turbo S</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('porsche911') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Rolls Royce Phantom/phantom1.jpg') }}" class="carsbox">
        <div class="card-content">
            <p>Rolls Royce Phantom</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('rollsroyce') }}">Érdekel</a>
        </div>
    </div>

    <div class="carbox1">
        <img src="{{ asset('images/Autok/Autok/Model S Paid/Tesla1.webp') }}" class="carsbox">
        <div class="card-content">
            <p>Tesla Model S Plaid</p>
            <p>-</p>
            <p><b>12.000.000 Ft</b></p>
            <a class="yellowbutton" href="{{ route('teslamodel') }}">Érdekel</a>
        </div>
    </div>

</div>
<style>
    .autocim{
        margin-top:130px;
        margin-bottom:40px;
        font-size:28px;
        margin-left:175px;
    }
</style>
</body>
</html>
