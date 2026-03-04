<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Hirdetésfeladás</title>
</head>
    @vite([
    'resources/css/profile.css',
    'resources/css/navbar.css',
])
<body>
   <x-navbar />

<div class="container">
<button class="vissza">Vissza</button>
    <h2>Új autó feltöltése</h2>

    <form method="POST" enctype="multipart/form-data" action="/admin/carcreate">
        @csrf

        <!-- Autó neve + képek + leírás -->
        <table class="form-table top-table">
            <tr>
                <td><label>Autó neve:</label></td>
                <td><input type="text" name="auto_nev" required></td>
            </tr>

            <tr>
                <td><label>Első kép:</label></td>
                <td><input type="file" name="image1" accept="image/*" required></td>
            </tr>

            <tr>
                <td><label>Második kép:</label></td>
                <td><input type="file" name="image2" accept="image/*" required></td>
            </tr>

            <tr>
                <td><label>Leírás:</label></td>
                <td><textarea name="leiras"></textarea></td>
            </tr>
        </table>

        <!-- Műszaki adatok -->
        <h2>Műszaki adatok</h2>

        <div class="tables-wrapper">

            <table class="form-table">

                <tr>
                    <td><label>Márka:</label></td>
                    <td>
                        <select name="marka">
                            <option value="">Válassz márkát</option>
                            <option>Audi</option> <option>BMW</option>
                            <option>Mercedes-Benz</option>
                            <option>Volkswagen</option>
                            <option>Toyota</option> <option>Honda</option>
                            <option>Ford</option> <option>Opel</option>
                            <option>Renault</option> <option>Peugeot</option>
                            <option>Nissan</option> <option>Kia</option>
                            <option>Hyundai</option>
                            <option>Ferrari</option> <option>Lamborghini</option>
                            <option>Porsche</option> <option>Maserati</option>
                            <option>Koenigsegg</option> <option>Bugatti</option>
                            <option>Rolls-Royce</option> <option>Bentley</option>
                            <option>Aston Martin</option> <option>McLaren</option>
                        </select>
                    </td>
                </tr>

                <tr><td><label>Modell:</label></td><td><input name="modell"></td></tr>
                <tr><td><label>Évjárat:</label></td><td><input type="number" name="evjarat"></td></tr>
                <tr><td><label>Kilométeróra:</label></td><td><input type="number" name="km"></td></tr>

                <tr>
                    <td><label>Ajtók száma:</label></td>
                    <td>
                        <select name="ajtok">
                            <option>2</option><option>3</option>
                            <option>4</option><option>5</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Üzemanyag:</label></td>
                    <td>
                        <select name="uzemanyag">
                            <option>Benzin</option><option>Dízel</option>
                            <option>Elektromos</option><option>Hibrid</option>
                            <option>LPG</option>
                        </select>
                    </td>
                </tr>

                <tr><td><label>Teljesítmény (LE):</label></td><td><input type="number" name="teljesitmeny"></td></tr>
            </table>

            <table class="form-table">

                <tr>
                    <td><label>Kivitel:</label></td>
                    <td>
                        <select name="kivitel">
                            <option>Coupe</option><option>Cabrio</option>
                            <option>Sedan</option><option>SUV</option>
                            <option>Hatchback</option><option>Pickup</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Állapot:</label></td>
                    <td>
                        <select name="allapot">
                            <option>Újszerű</option><option>Megkímélt</option>
                            <option>Normál</option><option>Sérült</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Szállítható személyek:</label></td>
                    <td>
                        <select name="szemelyek">
                            <option>2</option><option>4</option>
                            <option>5</option><option>7</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Szín:</label></td>
                    <td>
                        <select name="szin">
                            <option>Fekete</option><option>Fehér</option>
                            <option>Szürke</option><option>Piros</option>
                            <option>Kék</option><option>Zöld</option>
                            <option>Sárga</option><option>Ezüst</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Sebességváltó:</label></td>
                    <td>
                        <select name="sebessegvalto">
                            <option>Manuális</option><option>Automata</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Manuális:</label></td>
                    <td>
                        <select name="manualis">
                            <option>Igen</option><option>Nem</option>
                        </select>
                    </td>
                </tr>

                <tr><td><label>Hengerűrtartalom (cm³):</label></td><td><input type="number" name="hengerurtartalom"></td></tr>

            </table>

        </div>

        <button class="btn"type="submit">Autó feltöltése</button>

    </form>

</div>

</body>
</html>
