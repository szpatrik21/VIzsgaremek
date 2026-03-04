<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Admin – Kommentek</title>

    <style>
        :root {
            --black: #000;
            --white: #fff;
            --gold: #d4af37;
            --gray: #e6e6e6;
        }

        body {
            margin: 0;
            background: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        header {
            background: var(--black);
            color: var(--white);
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo { font-size: 22px; font-weight: bold; }
        .logo span { color: var(--gold); }

        .content {
            padding: 40px;
            max-width: 1000px;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 25px;
            border-left: 5px solid var(--gold);
            padding-left: 12px;
        }

        .comment-row {
            background: var(--white);
            border: 1px solid var(--gray);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
        }

        .comment-meta {
            font-size: 13px;
            color: #444;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .comment-meta strong { color: var(--gold); }

        .comment-text {
            font-size: 15px;
            line-height: 1.45;
            white-space: pre-wrap;
        }

        .danger-btn {
            background: #b00020;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .danger-btn:hover { filter: brightness(1.1); }

        .back-btn {
            background:#000;
            color:#d4af37;
            text-decoration:none;
            border:1px solid #d4af37;
            padding:10px 16px;
            border-radius:6px;
            font-weight:bold;
            display:inline-block;
        }

        .page-link {
            display:inline-block;
            padding:6px 10px;
            margin:0 4px;
            border-radius:6px;
            text-decoration:none;
            font-weight:bold;
            border:1px solid #d4af37;
        }
    </style>
</head>

<body>

<header>
    <div class="logo">Lux<span>Car</span> Admin</div>

    <a href="{{ route('admin.dashboard') }}" class="back-btn">
        Vissza
    </a>
</header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Autók kezelése</title>

    <style>
        body { font-family: Arial, sans-serif; background:#f3f3f3; margin:0; }
        .wrap { width: 1200px; margin: 40px auto; background:#fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,.08); }
        h1 { margin:0 0 20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e6e6e6; text-align:left; vertical-align: middle; }
        th { background:#111; color:#fff; }
        img { width: 120px; height: 70px; object-fit: cover; border-radius: 8px; }
        .rowform { display:flex; gap: 14px; align-items:center; flex-wrap: wrap; }
        .inp { width: 90px; padding: 8px; }
        .btn { padding: 9px 14px; border: none; border-radius: 8px; cursor:pointer; }
        .btn-save { background:#111; color:#fff; }
        .btn-save:hover { background:#d4af37; color:#111; }
        .btn-del { background:#b00020; color:#fff; }
        .btn-del:hover { filter: brightness(0.9); }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; display:inline-block; }
        .b-on { background:#d4af37; color:#111; }
        .b-off { background:#e9e9e9; color:#111; }
        .msg { margin: 10px 0 18px; font-weight: bold; }
        .ok { color: green; }
        .err { color: #b00020; }
        .radio { display:flex; gap:10px; align-items:center; }
        .muted { color:#666; font-size: 12px; }
    </style>
</head>
<body>


<div class="wrap">
    <h1>Autók kezelése</h1>

    @if(session('success'))
        <div class="msg ok">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="msg err">{{ $errors->first() }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kép</th>
                <th>Márka / Modell</th>
                <th>Ár</th>
                <th>Kiemelt</th>
                <th>Raktáron</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
        @foreach($autok as $auto)
            <tr>
                <td>{{ $auto->id }}</td>

                <td>
                    @if(!empty($auto->kep))
                        <img src="{{ asset($auto->kep) }}" alt="kep">
                    @else
                        <span class="muted">nincs kép</span>
                    @endif
                </td>

                <td>
                    <strong>{{ $auto->marka }} {{ $auto->modell }}</strong><br>
                    <span class="muted">{{ $auto->evjarat }} • {{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</span>
                </td>

                <td><strong>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</strong></td>

                <td>
                    @if($auto->kiemelt)
                        <span class="badge b-on">KIEMELT</span>
                    @else
                        <span class="badge b-off">nem</span>
                    @endif
                </td>

                <td>{{ $auto->raktaron }}</td>

                <td>
                    {{-- UPDATE FORM --}}
                    <form class="rowform" method="POST" action="{{ route('admin.cars.update', $auto->id) }}">
                        @csrf
                        @method('PATCH')

                        <label class="muted">Raktáron:</label>
                        <input class="inp" type="number" name="raktaron" min="0" value="{{ $auto->raktaron }}" required>

                        <div class="radio">
                            <label class="muted">Kiemelt:</label>

                            <label>
                                <input type="radio" name="kiemelt" value="1" {{ $auto->kiemelt ? 'checked' : '' }}>
                                Igen
                            </label>

                            <label>
                                <input type="radio" name="kiemelt" value="0" {{ !$auto->kiemelt ? 'checked' : '' }}>
                                Nem
                            </label>
                        </div>

                        <button class="btn btn-save" type="submit">Mentés</button>
                    </form>

                    {{-- DELETE FORM --}}
                    <form method="POST" action="{{ route('admin.cars.destroy', $auto->id) }}"
                          style="margin-top:10px;" onsubmit="return confirm('Biztos törlöd? ');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-del" type="submit">Törlés</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>