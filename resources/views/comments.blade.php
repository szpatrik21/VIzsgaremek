<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kommentek</title>
    <x-navbar />
</head>

<body>
<div class="container" style="max-width: 700px; margin: 30px auto;">
    
    <h1>Kommentek</h1>

    {{-- Komment írása --}}
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <textarea name="content" rows="4" class="form-control" placeholder="Írj egy kommentet..." required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Küldés</button>
    </form>

    <hr>

    {{-- Kommentek listája --}}
    @foreach ($comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $comment->user->name }}</strong>  
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                <p>{{ $comment->content }}</p>
            </div>
        </div>
    @endforeach
    
</div>
</body>
</html>
