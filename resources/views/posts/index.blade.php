<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts by David Peach</title>
</head>
<body>
    <h1>Posts by David Peach</h1>
    @foreach($posts as $post)
        <article>
            <h2>{{ $post->title }}</h2>
            <div>
                {{ $post->body }}
            </div>
        </article>
    @endforeach
</body>
</html>