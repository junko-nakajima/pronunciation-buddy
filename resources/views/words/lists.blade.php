<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>발음 버디</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Lesson Name</h1>
        <div class='words'>
            @foreach ($words as $word)
                <div class='word'>
                    <h2 class='title'>{{ $word->title }}</h2>
                    <p class='meaning'>{{ $word->meaning }}</p>
                </div>
            @endforeach
        </div>
    </body>
</html>