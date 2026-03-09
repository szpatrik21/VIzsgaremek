<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Új autó feltöltése</title>
  @vite([
    'resources/css/admin/carcreate.css'
  ])

</head>

<body>

<header>
    <div class="logo">Lux<span>Car</span> Admin</div>

    <a href="{{ route('admin.dashboard') }}" class="back-btn">
        Vissza
    </a>
</header>

<div class="container">

    <h2>Új autó feltöltése</h2>

    @if(session('success'))
        <p class="status success">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p class="status error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.carcreate.store') }}">
        @csrf

        <table class="form-table">
            <tr>
                <td><label for="image1">Első kép:</label></td>
                <td><input id="image1" type="file" name="image1" accept="image/*" required></td>
            </tr>

            <tr>
                <td><label for="image2">Második kép:</label></td>
                <td><input id="image2" type="file" name="image2" accept="image/*" required></td>
            </tr>
        </table>

        <h2>Műszaki adatok</h2>

        <div class="tables-wrapper">

            <table class="form-table">
                <tr>
                    <td><label for="marka">Márka:</label></td>
                    <td>
                        <select id="marka" name="marka" required>
                            <option value="">Válassz</option>
                            <option>Alfa Romeo</option>
                            <option>Aston Martin</option>
                            <option>Audi</option>
                            <option>Bentley</option>
                            <option>BMW</option>
                            <option>Bugatti</option>
                            <option>Cadillac</option>
                            <option>Ferrari</option>
                            <option>Genesis</option>
                            <option>Infiniti</option>
                            <option>Jaguar</option>
                            <option>Koenigsegg</option>
                            <option>Lamborghini</option>
                            <option>Land Rover</option>
                            <option>Lexus</option>
                            <option>Lotus</option>
                            <option>Maserati</option>
                            <option>Maybach</option>
                            <option>McLaren</option>
                            <option>Mercedes-Benz</option>
                            <option>Pagani</option>
                            <option>Porsche</option>
                            <option>Range Rover</option>
                            <option>Rimac</option>
                            <option>Rolls-Royce</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="modell">Modell:</label></td>
                    <td><input id="modell" name="modell" required></td>
                </tr>

                <tr>
                    <td><label for="evjarat">Évjárat:</label></td>
                    <td><input id="evjarat" type="number" name="evjarat" required></td>
                </tr>

                <tr>
                    <td><label for="kilometerora">Kilométeróra:</label></td>
                    <td><input id="kilometerora" type="number" name="kilometerora" value="0" required></td>
                </tr>

                <tr>
                    <td><label for="ajtok_szama">Ajtók száma:</label></td>
                    <td>
                        <select id="ajtok_szama" name="ajtok_szama" required>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="uzemanyag">Üzemanyag:</label></td>
                    <td>
                        <select id="uzemanyag" name="uzemanyag" required>
                            <option>Benzin</option>
                            <option>Dízel</option>
                            <option>Elektromos</option>
                            <option>Hibrid</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="teljesitmeny">Teljesítmény (LE):</label></td>
                    <td><input id="teljesitmeny" type="number" name="teljesitmeny" value="0" required></td>
                </tr>

                <tr>
                    <td><label for="ar">Ár (Ft):</label></td>
                    <td><input id="ar" type="number" name="ar" required></td>
                </tr>
            </table>

            <table class="form-table">
                <tr>
                    <td><label for="kivitel">Kivitel:</label></td>
                    <td>
                        <select id="kivitel" name="kivitel" required>
                            <option>Kupé</option>
                            <option>Szabadidő-autó</option>
                            <option>Limuzin</option>
                            <option>Terepjáró</option>
                            <option>Kabrió</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="allapot">Állapot:</label></td>
                    <td>
                        <select id="allapot" name="allapot" required>
                            <option>Új</option>
                            <option>Újszerű</option>
                            <option>Megkímélt</option>
                            <option>Normál</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="szemelyek_szama">Személyek száma:</label></td>
                    <td>
                        <select id="szemelyek_szama" name="szemelyek_szama" required>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="szin">Szín:</label></td>
                    <td>
                        <select id="szin" name="szin" required>
                            <optgroup label="Klasszikus elegáns">
                                <option>Fehér</option>
                                <option>Gyöngyház fehér</option>
                                <option>Fekete</option>
                                <option>Matt fekete</option>
                            </optgroup>

                            <optgroup label="Fémes / Metál">
                                <option>Ezüst</option>
                                <option>Szürke</option>
                                <option>Grafitszürke</option>
                                <option>Arany</option>
                                <option>Bronz</option>
                            </optgroup>

                            <optgroup label="Prémium mély árnyalatok">
                                <option>Kék</option>
                                <option>Zöld</option>
                                <option>Bordó</option>
                                <option>Barna</option>
                                <option>Bézs</option>
                            </optgroup>

                            <optgroup label="Sportos karakter">
                                <option>Piros</option>
                                <option>Sárga</option>
                                <option>Narancssárga</option>
                                <option>Lila</option>
                            </optgroup>

                            <optgroup label="Exkluzív különlegesség">
                                <option>Türkiz</option>
                                <option>Tükörkróm</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="sebessegvalto">Sebességváltó:</label></td>
                    <td>
                        <select id="sebessegvalto" name="sebessegvalto" required>
                            <option>Manuális</option>
                            <option>Automata</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="hengerurtartalom">Hengerűrtartalom (cm³):</label></td>
                    <td><input id="hengerurtartalom" type="number" name="hengerurtartalom" value="0" required></td>
                </tr>

                <tr>
                    <td><label for="raktaron">Raktáron (db):</label></td>
                    <td><input id="raktaron" type="number" name="raktaron" value="1" required></td>
                </tr>

                <tr>
                    <td><label for="kiemelt">Kiemelt:</label></td>
                    <td>
                        <select id="kiemelt" name="kiemelt">
                            <option value="0">Nem</option>
                            <option value="1">Igen</option>
                        </select>
                    </td>
                </tr>
            </table>

        </div>

        <button class="btn" type="submit">Autó feltöltése</button>
    </form>
</div>

</body>
</html>