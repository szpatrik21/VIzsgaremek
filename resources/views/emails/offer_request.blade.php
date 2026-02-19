<!doctype html>
<html lang="hu">
<body style="font-family: Arial, sans-serif;">
  <h2>Új ajánlatkérés 🚗</h2>

  <p><strong>Autó:</strong> {{ $auto->marka }} {{ $auto->modell }} ({{ $auto->evjarat }})</p>

  <hr>

  <p><strong>Név:</strong> {{ $data['name'] }}</p>
  <p><strong>Email:</strong> {{ $data['email'] }}</p>
  <p><strong>Telefon:</strong> {{ $data['phone'] ?? '-' }}</p>

  <hr>

  <p><strong>Üzenet:</strong></p>
  <p>{{ !empty($data['message']) ? e($data['message']) : '—' }}</p>
</body>
</html>
