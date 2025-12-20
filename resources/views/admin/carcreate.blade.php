<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar Admin – Autó feltöltése</title>

<style>
:root {
    --black: #000;
    --white: #fff;
    --gold: #d4af37;
    --gray: #ccc;
    --dark: #222;
}

body {
    font-family: Arial, sans-serif;
    background: #f0f0f0;
    margin: 0;
    padding: 0;
}

header {
    background: var(--black);
    padding: 18px 40px;
    color: var(--white);
    font-size: 22px;
    font-weight: bold;
}
header span { color: var(--gold); }

.container {
    width: 1200px;
    background: var(--white);
    margin: 40px auto;
    padding: 5px 40px 40px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2 {
    font-size: 26px;
    margin-top: 30px;
    margin-bottom: 15px;
    border-left: 5px solid var(--gold);
    padding-left: 12px;
}

label {
    font-weight: bold;
    margin-top: 15px;
    display: block;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid var(--gray);
    border-radius: 6px;
    font-size: 15px;
    background: var(--white);
}

textarea {
    height: 130px;
    resize: none;
}

.btn, .vissza {
    width: 100%;
    background: var(--black);
    color: var(--white);
    padding: 15px;
    font-size: 17px;
    border: none;
    border-radius: 6px;
    margin-top: 30px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover, .vissza:hover {
    background: var(--gold);
    color: var(--black);
}

.vissza {
    width: 90px;
    padding: 10px 5px;
}

.tables-wrapper {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    margin-top: 20px;
}

.form-table {
    width: 50%;
    table-layout: fixed;
}

.form-table td {
    padding: 10px 0;
    width: 50%;
}

/* ⭐ Beljebb tolt inputok → kisebb label cella */
.form-table td:first-child {
    width: 140px;
    padding-right: 8px; /* input közelebb kerül a labelhez */
}

.form-table td:last-child {
    width: auto;
}

/* 🔥 Egységes input + select méret */
.form-table input,
.form-table select {
    width: 260px !important;
    max-width: 260px;
    padding: 10px;
    border: 1px solid var(--gray);
    border-radius: 6px;
    background: var(--white);
    box-sizing: border-box;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Autó neve + képek */
.top-table input[type="text"],
.top-table input[type="file"] {
    width: 50%;
}
</style>


</head>
<body>
   <x-adminnavbar />

<style>
    .vissza{
        width: 90px;
        padding:10px 5px;
    }
</style>
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
