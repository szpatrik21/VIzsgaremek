<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    @vite(['resources/css/style4.css'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Autók</title>
</head>
<body>

<x-navbar />

<h2 class="autocim">Autók:</h2>

<div class="carbox">
    @foreach($autok as $auto)
        <div class="carbox1">
            @if(!empty($auto->kep))
                <img src="{{ asset($auto->kep) }}" class="carsbox" alt="{{ $auto->marka }} {{ $auto->modell }}">
            @else
                <img src="{{ asset('images/no-image.png') }}" class="carsbox" alt="Nincs kép">
            @endif

            <div class="card-content">
                <p>{{ $auto->marka }} {{ $auto->modell }}</p>
                <p>{{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</p>
                <p><b>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</b></p>

                <a class="yellowbutton" href="{{ route('autok.show', $auto->id) }}">Érdekel</a>
            </div>
        </div>
    @endforeach
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
